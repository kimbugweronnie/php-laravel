<?php
namespace App\Services;
use App\Models\ReportGroup;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use App\Http\Controllers\Controller;

class TemplateService extends Controller
{
   
    public function getexcel()
    {
        $reader = new Xlsx();
        $spreadsheet = $reader->load(public_path('HMIS 106a Template.xlsx'));
        $sheet1 = $spreadsheet->getActiveSheet('106a');
        $sheet2 = $spreadsheet->getActiveSheet('106b');
        return [$spreadsheet,$sheet1,$sheet2];
 
    }
}