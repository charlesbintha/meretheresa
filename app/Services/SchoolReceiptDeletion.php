<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SchoolReceiptDeletion
{
    public function execute(string $action, array $payload, int $id, User $actor, int $year): int
    {
        // SchoolStore runs every command in a transaction under the school settings lock.
        $requests = DB::table('school_receipt_deletion_requests')->where('academic_year_id', $year);
        if ($action === 'billing-delete-request') {
            $reason = Validator::make($payload, ['reason' => 'required|string|max:500'])->validate()['reason'];
            $receipt = DB::table('school_receipts')->whereIn('charge_id',
                DB::table('school_charges')->where('academic_year_id', $year)->select('id')
            )->find($id) ?? abort(404);

            $existing = (clone $requests)->where('receipt_id', $id)->where('status', 'pending')->value('id');
            if ($existing) {
                return $existing;
            }

            return DB::table('school_receipt_deletion_requests')->insertGetId([
                'receipt_id' => $id,
                'academic_year_id' => $year,
                'requested_by' => $actor->id,
                'reason' => $reason,
                'receipt_snapshot' => json_encode($receipt, JSON_THROW_ON_ERROR),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        abort_unless($actor->isSchoolAdministrator(), 403);
        $request = $requests->find($id) ?? abort(404);
        abort_unless($request->status === 'pending', 422, 'Cette demande a déjà été traitée.');
        $approved = $action === 'billing-delete-approve';
        if ($approved) {
            $entries = DB::table('accounting_entries')->where('source_key', 'school_receipts:'.$request->receipt_id);
            $entry = $entries->first();
            if ($entry && $entry->status === 'posted') {
                abort_unless(DB::table('accounting_entries')->where('reversal_of', $entry->id)->where('status', 'posted')->exists(),
                    422, 'Ce paiement est comptabilisé. Validez d’abord la contrepassation dans les écritures comptables.');
            }
            $entries->where('status', 'draft')->delete();
            abort_unless(DB::table('school_receipts')->where('id', $request->receipt_id)->delete() === 1, 404);
        }

        $requests->where('id', $id)->update([
            'status' => $approved ? 'approved' : 'rejected',
            'decided_by' => $actor->id,
            'decided_at' => now(),
            'updated_at' => now(),
        ]);

        return $id;
    }
}
