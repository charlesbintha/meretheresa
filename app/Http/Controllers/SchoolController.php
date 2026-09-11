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

        $result = $store->command($v['action'], $v['payload'], $v['id'] ?? null, $r->user()->id, $v['revision']);
        if ($v['action'] === 'profile') {
            $fresh = $r->user()->fresh();
            \Illuminate\Support\Facades\Auth::setUser($fresh);
            $r->session()->regenerate();
            $r->session()->put('school_auth_version', $fresh->auth_version);
            $result['csrfToken'] = $r->session()->token();
        }

        return response()->json($result)->header('Cache-Control', 'no-store, private');
    }
}
