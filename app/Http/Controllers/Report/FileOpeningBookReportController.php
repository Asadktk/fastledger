<?php

namespace App\Http\Controllers\Report;
use Barryvdh\DomPDF\Facade as PDF;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\FileOpeningReport;
use App\Models\File;
 use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class FileOpeningBookReportController extends Controller
{ 
    public function index()
    {
        return view('admin.reports.file_opening_book_report');
    }

    public function getData(Request $request)
    {
        $userClientId = Auth::user()->Client_ID;

        $query = File::where('Client_ID', $userClientId)
                    ->whereBetween('File_Date', [$request->from_date, $request->to_date])
                    ->orderBy('File_Date', 'desc');

        $files = $query->paginate(10);

        return response()->json([
            'data' => $files->items(),
            'pagination' => $files->links()->render()
        ]);
    }
    public function downloadPDF(Request $request)
    {
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');

        $data = File::whereBetween('File_Date', [$fromDate, $toDate])->get();

        $pdf = PDF::loadView('reports.file_report_pdf', compact('data', 'fromDate', 'toDate'));
        return $pdf->download('File_Report_'.$fromDate.'_to_'.$toDate.'.pdf');
    }

    public function downloadCSV(Request $request)
    {
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');

        $data = File::whereBetween('File_Date', [$fromDate, $toDate])->get();

        $fileName = 'File_Report_'.$fromDate.'_to_'.$toDate.'.csv';

        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $handle = fopen('php://output', 'w');
        fputcsv($handle, ["S/No", "File Open Date", "Ledger Ref", "Matter", "Client Name", "Address", "Fee Earner", "Status", "Close Date"]);

        foreach ($data as $index => $record) {
            fputcsv($handle, [
                $index + 1,
                $record->File_Date,
                $record->Ledger_Ref,
                $record->Matter,
                $record->First_Name . ' ' . $record->Last_Name,
                $record->Address1 . ' ' . $record->Address2 . ' ' . $record->Town . ' ' . $record->Post_Code,
                $record->Fee_Earner,
                $record->Status,
                $record->File_Date
            ]);
        }

        fclose($handle);

        return Response::make('', 200, $headers);
    }
}
