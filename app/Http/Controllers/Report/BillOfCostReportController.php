<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
 
use Barryvdh\DomPDF\Facade as PDF;
 
use App\DataTables\FileOpeningReport;
use App\Models\File;
 use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
class BillOfCostReportController extends Controller
{
    public function index()
    {
       
         
        return view('admin.reports.bill_of_cost_rep');
    }
}
