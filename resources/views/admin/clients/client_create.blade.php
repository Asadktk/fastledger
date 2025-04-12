@extends('admin.layout.app')

@section('content')
    <div class="main-content app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card custom-card">
                        <div class="card-header justify-content-between">
                            <div class="card-title">Complete Form</div>
                            <div class="prism-toggle">
                                <button class="btn btn-sm btn-primary-light">Show Code<i
                                        class="ri-code-line ms-2 d-inline-block align-middle"></i></button>
                            </div>
                        </div>
                        <div class="card-body">
                            <form id="fileForm" method="POST" action="{{ route('clients.store') }}">
                                @csrf
                        
                                <!-- Row: Client Ref# and Contact Name -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Client Ref# *</label>
                                        <input type="text" class="form-control" name="Client_Ref"
                                            placeholder="Client Reference Number" required />
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Contact Name *</label>
                                        <input type="text" class="form-control" name="Contact_Name"
                                            placeholder="Contact Name" required />
                                    </div>
                                </div>
                        
                                <!-- Row: Business Name and Company Reg No -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Business Name</label>
                                        <input type="text" class="form-control" name="Business_Name"
                                            placeholder="Business Name" />
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Company Reg No</label>
                                        <input type="text" class="form-control" name="Company_Reg_No"
                                            placeholder="Company Registration Number" />
                                    </div>
                                </div>
                        
                                <!-- Address 1 -->
                                <div class="mb-3">
                                    <label class="form-label">Address Line 1</label>
                                    <input type="text" class="form-control" name="Address1"
                                        placeholder="Address Line 1" />
                                </div>
                        
                                <!-- Address 2 -->
                                <div class="mb-3">
                                    <label class="form-label">Address Line 2</label>
                                    <input type="text" class="form-control" name="Address2"
                                        placeholder="Address Line 2" />
                                </div>
                        
                                <!-- Row: Town and Post Code -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Town</label>
                                        <input type="text" class="form-control" name="Town"
                                            placeholder="Town" />
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Post Code *</label>
                                        <input type="text" class="form-control" name="Post_Code"
                                            placeholder="Post Code" required />
                                    </div>
                                </div>
                        
                                <!-- Row: Country and Phone -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Country *</label>
                                        <select class="form-control" name="Country_ID" required>
                                            <option value="">Select Country</option>
                                            @foreach ($countries as $country)
                                                <option value="{{ $country->Country_ID }}">{{ $country->Country_Name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Phone *</label>
                                        <input type="text" class="form-control" name="Phone"
                                            placeholder="Phone Number" required />
                                    </div>
                                </div>
                        
                                <!-- Row: Mobile and Fax -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Mobile</label>
                                        <input type="text" class="form-control" name="Mobile"
                                            placeholder="Mobile Number" />
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Fax</label>
                                        <input type="text" class="form-control" name="Fax"
                                            placeholder="Fax Number" />
                                    </div>
                                </div>
                        
                                <!-- Row: Email and Contact No -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control" name="Email"
                                            placeholder="Email Address" />
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Contact No</label>
                                        <input type="text" class="form-control" name="Contact_No"
                                            placeholder="Contact Number" />
                                    </div>
                                </div>
                        
                                <!-- Row: VAT Registration No and Fee Agreed -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">VAT Registration No</label>
                                        <input type="text" class="form-control" name="VAT_Registration_No"
                                            placeholder="VAT Registration Number" />
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Fee Agreed</label>
                                        <input type="number" step="0.01" class="form-control" name="Fee_Agreed"
                                            placeholder="Fee Agreed" />
                                    </div>
                                </div>
                        
                                <!-- Row: Admin UserName and Password -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Admin User Name *</label>
                                        <input type="text" class="form-control" name="AdminUserName"
                                            placeholder="Admin User Name" required />
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Admin Password *</label>
                                        <input type="password" class="form-control" name="AdminPassword"
                                            placeholder="Admin Password" required />
                                    </div>
                                </div>
                        
                                <!-- Submit Button -->
                                <div class="mb-3 text-end">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
                        

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
