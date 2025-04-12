<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Client;
use App\Models\Country;
use Illuminate\Http\Request;
use App\DataTables\ClientDataTable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreClientRequest;

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
        $countries = Country::all();
        // dd($countries);
        return view('admin.clients.client_create' , compact('countries'));
    }

    public function store(StoreClientRequest $request)
    {
        // dd($request->all());
        // Store Client Domain
        $client = new Client();
        $client->Client_Ref = $request->Client_Ref;
        $client->Contact_Name = $request->Contact_Name;
        $client->Business_Name = $request->Business_Name;
        $client->Address1 = $request->Address1;
        $client->Address2 = $request->Address2;
        $client->Town = $request->Town;
        $client->Country_ID = $request->Country_ID;
        $client->Post_Code = $request->Post_Code;
        $client->Phone = $request->Phone;
        $client->Mobile = $request->Mobile;
        $client->Fax = $request->Fax;
        $client->Email = $request->Email;
        $client->Company_Reg_No = $request->Company_Reg_No;
        $client->VAT_Registration_No = $request->VAT_Registration_No;
        $client->Contact_No = $request->Contact_No;
        $client->Fee_Agreed = $request->Fee_Agreed;
        $client->Is_Archive = 1; // 0 = not archived
        $client->Created_By = Auth::id();
        $client->date_lock = ''; // if the DB column allows null
        $client->transaction_lock = ''; // if the DB column allows null
        $client->Created_On = now();
        $client->save();
    
        // Store Admin User
        $adminUser = new User();
        $adminUser->Full_Name = $request->AdminUserName;
        $adminUser->User_Name = $request->AdminUserName;
        $adminUser->password = Hash::make($request->AdminPassword); // 🔒 Laravel recommended hashing
        $adminUser->email = $request->Email ?? ''; // use client email if provided
        $adminUser->Is_Active = 1;
        $adminUser->Is_Archive = 1;
        $adminUser->User_Role = 2; // 2 = client role id
        $adminUser->Created_By= Auth::id();
        $adminUser->Created_On = now();
        $adminUser->save();
    
        return redirect()->back()->with('success', 'Client and Admin User created successfully.');
    }
}





