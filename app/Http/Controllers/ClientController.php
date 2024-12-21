<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use App\DataTables\ClientDataTable;

class ClientController extends Controller
{
    public function index(ClientDataTable $dataTable, $type = 'active')
    {
        // Determine the view based on the `type` parameter
        $view = $type === 'archived' ? 'admin.clients.client_archieve' : 'admin.clients.client_active';

        return $dataTable->with('type', $type)->render($view);
    }

    public function create()
    {
        return view('admin.clients.client_create');
    }

    public function store(Request $request)
    {
        $client = Client::create($request->only([
            'client_ref',
            'contact_name',
            'business_name',
            'address1',
            'address2',
            'town',
            'country_id',
            'post_code',
            'phone',
            'mobile',
            'fax',
            'email',
            'company_reg_no',
            'vat_registration_no',
            'contact_no',
            'fee_agreed',
            'created_by',
            'created_on'
        ]));

        return response()->json(['message' => 'Client created successfully', 'data' => $client], 201);
    }
}
