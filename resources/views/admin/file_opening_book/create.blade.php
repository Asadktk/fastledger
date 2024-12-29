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
                                {{-- <button class="btn btn-sm btn-primary-light">Show Code<i
                                        class="ri-code-line ms-2 d-inline-block align-middle"></i></button> --}}
                            </div>
                        </div>
                        <div class="card-body">
                            <x-form method="POST" action="/files">
                                {{-- <input type="hidden" name="File_ID" value="" />
                                <input type="hidden" name="Client_ID" value="" /> --}}

                                <div class="row">
                                    <!-- Name Fields -->
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">First Name</label>
                                        <input type="text" class="form-control" name="First_Name"
                                            placeholder="First name" />
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Last Name</label>
                                        <input type="text" class="form-control" name="Last_Name"
                                            placeholder="Last name" />
                                    </div>

                                    <!-- Date and Contact Details -->
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">File Date (dd/mm/yyyy)</label>
                                        <input type="date" class="form-control" name="File_Date"
                                            placeholder="dd/mm/yyyy" />
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Phone</label>
                                        <input type="text" class="form-control" name="Phone"
                                            placeholder="Phone number" />
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Mobile</label>
                                        <input type="text" class="form-control" name="Mobile"
                                            placeholder="Mobile number" />
                                    </div>

                                    <!-- Address Fields -->
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Address 1</label>
                                        <input type="text" class="form-control" name="Address1"
                                            placeholder="Address 1" />
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Address 2</label>
                                        <input type="text" class="form-control" name="Address2"
                                            placeholder="Address 2" />
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label">Town</label>
                                        <input type="text" class="form-control" name="Town" placeholder="Town" />
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label">Post Code</label>
                                        <input type="text" class="form-control" name="Post_Code"
                                            placeholder="Post Code" />
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Country</label>
                                        <select name="Country_ID" class="form-select">
                                            <option selected disabled>Select Country</option>
                                            @foreach ($countries as $country)
                                                <option value="{{ $country->Country_ID }}">{{ $country->Country_Name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>


                                    <!-- Additional Information -->
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Ledger Ref#</label>
                                        <input type="text" class="form-control" name="Ledger_Ref"
                                            placeholder="Ledger Reference" />
                                    </div>
                                    <!-- Matter Dropdown -->
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Matter</label>
                                        <select name="Matter" id="matter" class="form-select">
                                            <option selected disabled>Select Matter</option>
                                            @foreach ($matters as $matter)
                                                <option value="{{ $matter->id }}">{{ $matter->matter }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Sub Matter Dropdown -->
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Sub Matter</label>
                                        <select name="Sub_Matter" id="submatter" class="form-select">
                                            <option selected disabled>Select Sub Matter</option>
                                        </select>
                                    </div>
                                    <!-- Additional Contact Info -->
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control" name="Email" placeholder="Email" />
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Referral Name</label>
                                        <input type="text" class="form-control" name="Referral_Name"
                                            placeholder="Referral Name" />
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Referral Fee</label>
                                        <input type="text" class="form-control" name="Referral_Fee"
                                            placeholder="Referral Fee" />
                                    </div>

                                    <!-- Fee and Status Fields -->
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Fee Agreed</label>
                                        <input type="text" class="form-control" name="Fee_Agreed"
                                            placeholder="Fee Agreed" />
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Status</label>
                                        <select name="Status" class="form-select">
                                            <option value="">Select Status</option>
                                            <option value="L">Live</option>
                                            <option value="C">Close</option>
                                            <option value="A">Abortive</option>
                                            <option value="I">Close Abortive</option>
                                        </select>
                                    </div>

                                    <!-- Missing Fields -->
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">NIC No</label>
                                        <input type="text" class="form-control" name="NIC_No"
                                            placeholder="NIC No" />
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Date of Birth</label>
                                        <input type="date" class="form-control" name="Date_Of_Birth"
                                            placeholder="Date of Birth" />
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Key Date</label>
                                        <input type="date" class="form-control" name="Key_Date"
                                            placeholder="Key Date" />
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Special Note</label>
                                        <textarea class="form-control" name="Special_Note" placeholder="Special Note"></textarea>
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </x-form>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<!-- jQuery Script for AJAX -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#matter').on('change', function() {
            var matterId = $(this).val();
            
            if (matterId) {
                $.ajax({
                    url: '/matters/' + matterId + '/submatters',
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#submatter').empty().append('<option selected disabled>Select Sub Matter</option>');
                        $.each(data, function(index, submatter) {
                            $('#submatter').append('<option value="' + submatter.id + '">' + submatter.submatter + '</option>');
                        });
                    }
                });
            } else {
                $('#submatter').empty().append('<option selected disabled>Select Sub Matter</option>');
            }
        });
    });
</script>