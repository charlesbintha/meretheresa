<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::transaction(function () {
            $settings = DB::table('school_settings')->where('id', 1)->lockForUpdate()->first();
            if (! $settings) {
                return;
            }
            $values = json_decode($settings->values, true);
            $old = $values['school'] ?? '';
            $values['school'] = str_replace(['Mère Teresa', 'Mère Theresa'], 'Mère Thérèsa', $old);
            if ($values['school'] !== $old) {
                DB::table('school_settings')->where('id', 1)->update([
                    'values' => json_encode($values, JSON_UNESCAPED_UNICODE),
                    'revision' => $settings->revision + 1, 'updated_at' => now(),
                ]);
            }
        });
    }

    public function down(): void
    {
        // Keep the corrected name when rolling back; other settings are unchanged.
    }
};
