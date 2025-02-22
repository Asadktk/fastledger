<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ClientBankReconciliationController extends Controller
{
    public function index()
    {
       
        return view('admin.reports.client_bank_reconciliation');
    }
}
