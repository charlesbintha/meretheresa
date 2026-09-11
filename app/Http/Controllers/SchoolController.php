<?php

namespace App\Http\Controllers;

use App\Services\SchoolStore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SchoolController extends Controller
{
    public function index()
    {
        return response()->view('school.app')->header('Cache-Control', 'no-store, private');
    }

    public function state(Request $r, SchoolStore $store)
    {
        return DB::transaction(function () use ($r, $store) {
            DB::table('school_settings')->where('id', 1)->lockForUpdate()->first();

            return response()->json($store->state($r->user()->id))->header('Cache-Control', 'no-store, private');
        });
    }

    public function command(Request $r, SchoolStore $store)
    {
        $v = $r->validate(['action' => 'required|string|max:40', 'payload' => 'present|array', 'id' => 'nullable|string|max:100', 'revision' => 'required|integer|min:1']);

        return response()->json($store->command($v['action'], $v['payload'], $v['id'] ?? null, $r->user()->id, $v['revision']))->header('Cache-Control', 'no-store, private');
    }
}
