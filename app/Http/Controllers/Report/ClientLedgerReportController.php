<?php

namespace App\Http\Controllers\Report;

namespace App\Http\Controllers\Report;
use Barryvdh\DomPDF\Facade as PDF;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\FileOpeningReport;
use App\Models\File;
 use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
class ClientLedgerReportController extends Controller
{
    public function index()
    {
        $userClientId = Auth::user()->Client_ID;
        $query = File::where('Client_ID', $userClientId)
         ->orderBy('File_Date', 'desc');
         
        return view('admin.reports.clientLedger');
    }
}
