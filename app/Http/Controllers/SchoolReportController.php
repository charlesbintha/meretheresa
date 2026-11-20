<?php
namespace App\Http\Controllers;
use App\Services\SchoolReports;
use Illuminate\Http\Request;
class SchoolReportController extends Controller {
 public function index(Request $r,SchoolReports $reports){abort_unless($r->user()->canSchool('grades.view'),403);$v=$r->validate(['classId'=>'required|integer','term'=>'required|integer|min:1|max:3']);return response()->json($reports->overview($v['classId'],$v['term']))->header('Cache-Control','no-store, private');}
 public function show(Request $r,SchoolReports $reports,int $id){abort_unless($r->user()->canSchool('grades.view'),403);return response()->json($reports->saved($id))->header('Cache-Control','no-store, private');}
 public function store(Request $r,SchoolReports $reports){abort_unless($r->user()->canSchool('grades.manage'),403);$v=$r->validate(['classId'=>'required|integer','term'=>'required|integer|min:1|max:3','students'=>'required|array|min:1|max:100','students.*.id'=>'required|integer|distinct','students.*.comment'=>'nullable|string|max:500','students.*.absences'=>'nullable|integer|min:0|max:200','students.*.late'=>'nullable|integer|min:0|max:200']);return response()->json(['cards'=>$reports->generate($r->user(),$v)])->header('Cache-Control','no-store, private');}
}
