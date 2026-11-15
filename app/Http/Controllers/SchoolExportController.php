<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Dompdf\Dompdf;
use Dompdf\Options;
class SchoolExportController extends Controller {
 public function __invoke(Request $request) {
  $v=$request->validate(['format'=>'required|in:xlsx,pdf','scope'=>'required|in:students,academics,grades,finance,services,accounting','name'=>'required|string|max:100','headers'=>'required|array|min:1|max:25','headers.*'=>'required|string|max:100','rows'=>'present|array|max:10000','rows.*'=>'array|max:25','rows.*.*'=>'nullable']);
  abort_unless($request->user()->canSchool($v['scope'].'.view'),403);
  $headers=$v['headers'];$rows=[];foreach($v['rows'] as $row){abort_unless(count($row)===count($headers),422);$out=[];foreach($row as $i=>$value){abort_if(is_array($value)||is_object($value)||mb_strlen((string)$value)>2000,422);$out[]=$value;} $rows[]=$out;}
  $name=Str::slug($v['name'])?:'export';$title=str_replace(['-','_'],' ',$v['name']);$date=now()->timezone('Africa/Dakar')->format('d/m/Y H:i');
  if($v['format']==='xlsx'){
   $book=new Spreadsheet;$sheet=$book->getActiveSheet();$sheet->setTitle('Export');$last=Coordinate::stringFromColumnIndex(count($headers));
   $sheet->mergeCells('A1:'.$last.'1')->setCellValueExplicit('A1','Mère Thérèsa · '.$title,DataType::TYPE_STRING);$sheet->setCellValue('A2','Édité le '.$date);$sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
   foreach($headers as $i=>$header)$sheet->setCellValueExplicit([$i+1,4],$header,DataType::TYPE_STRING);
   foreach($rows as $r=>$row)foreach($row as $c=>$value){
    $numeric=is_int($value)||is_float($value);
    if(!$numeric&&preg_match('/montant|total|solde|debit|credit|tarif|exoner|verse|reste|moyenne|note|prevu|regle|ouverture|cloture/i',Str::ascii($headers[$c]))){$candidate=preg_replace('/[\s\x{00A0}\x{202F}]/u','',(string)$value);$candidate=preg_replace('/(?:FCFA|F)$/i','',$candidate);if(preg_match('/^-?\d+(?:[.,]\d+)?$/',$candidate)){$value=(float)str_replace(',','.',$candidate);$numeric=true;}}
    $sheet->setCellValueExplicit([$c+1,$r+5],$value??'',$numeric?DataType::TYPE_NUMERIC:DataType::TYPE_STRING);
    if($numeric)$sheet->getStyle([$c+1,$r+5])->getNumberFormat()->setFormatCode(is_int($value)||floor($value)==$value?'#,##0':'#,##0.00');
   }
   $sheet->freezePane('A5');$sheet->setAutoFilter('A4:'.$last.max(4,count($rows)+4));$sheet->getStyle('A4:'.$last.'4')->getFont()->setBold(true)->getColor()->setARGB('FFFFFFFF');$sheet->getStyle('A4:'.$last.'4')->getFill()->setFillType('solid')->getStartColor()->setARGB('FF2864F6');
   foreach($headers as $i=>$h)$sheet->getColumnDimension(Coordinate::stringFromColumnIndex($i+1))->setWidth(min(44,max(18,mb_strlen($h)+5)));
   $sheet->getStyle('A4:'.$last.max(5,count($rows)+4))->getAlignment()->setWrapText(true)->setVertical('top');
   return response()->streamDownload(function()use($book){(new Xlsx($book))->save('php://output');$book->disconnectWorksheets();},$name.'.xlsx',['Content-Type'=>'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet','Cache-Control'=>'no-store, private']);
  }
  // Escape every cell; document rendering never fetches external content or executes scripts.
  $html='<html><meta charset="utf-8"><style>@page{margin:30px 22px}body{font-family:DejaVu Sans;font-size:8px;color:#253247}h1{font-size:16px;color:#2257c9}table{border-collapse:collapse;width:100%;table-layout:fixed}thead{display:table-header-group}tr{page-break-inside:avoid}td,th{border-bottom:1px solid #dce4ef;padding:5px;overflow-wrap:break-word;word-wrap:break-word}th{background:#eaf0ff;text-align:left}.meta{color:#63728a;margin-bottom:16px}</style><h1>Mère Thérèsa · '.e($title).'</h1><p class="meta">Édité le '.e($date).' · '.count($rows).' lignes</p><table><thead><tr>'.implode('',array_map(fn($h)=>'<th>'.e($h).'</th>',$headers)).'</tr></thead><tbody>';
  foreach($rows as $row)$html.='<tr>'.implode('',array_map(fn($c)=>'<td>'.e(is_int($c)||is_float($c)?number_format($c,$c==floor($c)?0:2,',',' '):(string)($c??'')).'</td>',$row)).'</tr>';
  $html.='</tbody></table></html>';$options=new Options;$options->setIsRemoteEnabled(false);$options->setIsPhpEnabled(false);$options->setIsJavascriptEnabled(false);$pdf=new Dompdf($options);$pdf->loadHtml($html,'UTF-8');$pdf->setPaper('A4',count($headers)>5?'landscape':'portrait');$pdf->render();$canvas=$pdf->getCanvas();$canvas->page_text(25,$canvas->get_height()-20,'Page {PAGE_NUM} / {PAGE_COUNT}',null,7,[.4,.4,.4]);return response($pdf->output(),200,['Content-Type'=>'application/pdf','Content-Disposition'=>'attachment; filename="'.$name.'.pdf"','Cache-Control'=>'no-store, private']);
 }
}
