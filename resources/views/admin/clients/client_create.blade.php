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
                            <form id="fileForm" method="post" action="#">
                                <input type="hidden" name="hndFileID" value="" />
                                <input type="hidden" name="hndClientID" value="" />

                                <div class="row">
                                    <!-- Name Fields -->
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">First Name</label>
                                        <input type="text" class="form-control" name="txtFirstName"
                                            placeholder="First name" />
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Last Name</label>
                                        <input type="text" class="form-control" name="txtLastName"
                                            placeholder="Last name" />
                                    </div>

                                    <!-- Date and Contact Details -->
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Date (dd/mm/yyyy)</label>
                                        <input type="text" class="form-control" name="txtDate"
                                            placeholder="dd/mm/yyyy" />
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Contact Number</label>
                                        <input type="text" class="form-control" name="txtPhone"
                                            placeholder="Phone number" />
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Alternative Contact</label>
                                        <input type="text" class="form-control" name="txtMobile"
                                            placeholder="Alternative phone" />
                                    </div>

                                    <!-- Address Fields -->
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Address</label>
                                        <input type="text" class="form-control" name="txtStreet" placeholder="Street" />
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label">Town</label>
                                        <input type="text" class="form-control" name="txtTown" placeholder="Town" />
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label">Post Code</label>
                                        <input type="text" class="form-control" name="txtPostCode"
                                            placeholder="Post Code" />
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Country</label>
                                        <select name="txtCountry" class="form-select">
                                            <option selected>Select Country</option>
                                            <option value="1">Country 1</option>
                                            <option value="2">Country 2</option>
                                        </select>
                                    </div>

                                    <!-- Additional Information -->
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Ledger Ref#</label>
                                        <input type="text" class="form-control" name="txtLedgerRef"
                                            placeholder="Ledger Reference" />
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Matter</label>
                                        <input type="text" class="form-control" name="txtMatter" placeholder="Matter" />
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Sub Matter</label>
                                        <input type="text" class="form-control" name="txtSubMatter"
                                            placeholder="Sub Matter" />
                                    </div>

                                    <!-- Additional Contact Info -->
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control" name="txtEmail" placeholder="Email" />
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Referral Name</label>
                                        <input type="text" class="form-control" name="txtReferralName"
                                            placeholder="Referral Name" />
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Referral Fee</label>
                                        <input type="text" class="form-control" name="txtReferralFee"
                                            placeholder="Referral Fee" />
                                    </div>

                                    <!-- Fee and Status Fields -->
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Fee Agreed</label>
                                        <input type="text" class="form-control" name="txtFeeAgreed"
                                            placeholder="Fee Agreed" />
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Status</label>
                                        <select name="txtStatus" class="form-select">
                                            <option value="">Select Status</option>
                                            <option value="L">Live</option>
                                            <option value="C">Close</option>
                                            <option value="A">Abortive</option>
                                        </select>
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
