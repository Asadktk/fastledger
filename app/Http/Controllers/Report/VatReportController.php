<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VatReportController extends Controller
{
    public function index()
    { 
        return view('admin.reports.vat_report');
    }
}
