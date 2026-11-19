<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{DB,Storage};
class SchoolExpenseDocumentController extends Controller {
 public function store(Request $r,int $id){
  abort_unless($r->user()->canSchool('accounting.manage'),403);
  abort_unless(DB::table('school_expenses')->where('id',$id)->exists(),404);
  $r->validate(['document'=>'required|file|mimes:pdf,jpg,jpeg,png|max:10240']);
  $file=$r->file('document');$path=$file->store('expense-documents','local');abort_unless($path,500);
  try {$record=DB::transaction(function()use($r,$id,$file,$path){
   $doc=DB::table('school_expense_documents')->insertGetId(['expense_id'=>$id,'name'=>mb_substr(basename($file->getClientOriginalName()),0,255),'path'=>$path,'uploaded_by'=>$r->user()->id,'created_at'=>now(),'updated_at'=>now()]);
   DB::table('school_audit_logs')->insert(['user_id'=>$r->user()->id,'action'=>'expense-document','record_id'=>(string)$doc,'created_at'=>now(),'updated_at'=>now()]);return $doc;
  });}catch(\Throwable $e){Storage::disk('local')->delete($path);throw $e;}
  return response()->json(['id'=>$record],201);
 }
 public function show(Request $r,int $id){
  abort_unless($r->user()->canSchool('accounting.view'),403);
  $doc=DB::table('school_expense_documents')->find($id);abort_unless($doc&&Storage::disk('local')->exists($doc->path),404);
  return Storage::disk('local')->download($doc->path,$doc->name,['Cache-Control'=>'no-store, private','X-Content-Type-Options'=>'nosniff']);
 }
}
