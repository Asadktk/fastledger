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
                                        <input type="text" class="form-control @error('First_Name') is-invalid @enderror"
                                            name="First_Name" placeholder="First name" />
                                        @error('First_Name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Last Name</label>
                                        <input type="text" class="form-control @error('Last_Name') is-invalid @enderror"
                                            name="Last_Name" placeholder="Last name" />

                                        @error('Last_Name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Date and Contact Details -->
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">File Date (dd/mm/yyyy)</label>
                                        <input type="date" class="form-control @error('File_Date') is-invalid @enderror"
                                            name="File_Date" placeholder="dd/mm/yyyy" />

                                        @error('File_Date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
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
                                        <input type="text" class="form-control @error('Address1') is-invalid @enderror" name="Address1"
                                            placeholder="Address 1" />

                                            @error('Address1')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Address 2</label>
                                        <input type="text" class="form-control" name="Address2"
                                            placeholder="Address 2" />
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label">Town</label>
                                        <input type="text" class="form-control @error('Town') is-invalid @enderror" name="Town" placeholder="Town" />

                                        @error('Town')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label">Post Code</label>
                                        <input type="text" class="form-control @error('Post_Code') is-invalid @enderror" name="Post_Code"
                                            placeholder="Post Code" />

                                            @error('Post_Code')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror

                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Country</label>
                                        <select name="Country_ID" class="form-select @error('Country_ID') is-invalid @enderror">
                                            <option selected disabled>Select Country</option>
                                            @foreach ($countries as $country)
                                                <option value="{{ $country->Country_ID }}">{{ $country->Country_Name }}
                                                </option>
                                            @endforeach
                                        </select>

                                        @error('Country_ID')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>


                                    <!-- Additional Information -->
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Ledger Ref#</label>
                                        <input type="text" class="form-control @error('Ledger_Ref') is-invalid @enderror" name="Ledger_Ref"
                                            placeholder="Ledger Reference" />

                                            @error('Ledger_Ref')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <!-- Matter Dropdown -->
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Matter</label>
                                        <select name="Matter" id="matter" class="form-select @error('Matter') is-invalid @enderror">
                                            <option selected disabled>Select Matter</option>
                                            @foreach ($matters as $matter)
                                                <option value="{{ $matter->id }}">{{ $matter->matter }}</option>
                                            @endforeach
                                        </select>

                                        @error('Matter')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
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
                                        <input type="number" class="form-control @error('Referral_Fee') is-invalid @enderror" name="Referral_Fee"
                                            placeholder="Referral Fee" />

                                            @error('Referral_Fee')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Fee and Status Fields -->
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Fee Agreed</label>
                                        <input type="number" class="form-control @error('Fee_Agreed') is-invalid @enderror" name="Fee_Agreed"
                                            placeholder="Fee Agreed" />

                                            @error('Fee_Agreed')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Status</label>
                                        <select name="Status" class="form-select @error('Status') is-invalid @enderror">
                                            <option value="">Select Status</option>
                                            <option value="L">Live</option>
                                            <option value="C">Close</option>
                                            <option value="A">Abortive</option>
                                            <option value="I">Close Abortive</option>
                                        </select>

                                        @error('Status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
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

@section('scripts')
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
                        $('#submatter').empty().append(
                            '<option selected disabled>Select Sub Matter</option>');
                        $.each(data, function(index, submatter) {
                            $('#submatter').append('<option value="' + submatter
                                .id + '">' + submatter.submatter + '</option>');
                        });
                    }
                });
            } else {
                $('#submatter').empty().append('<option selected disabled>Select Sub Matter</option>');
            }
        });
    });
</script>
@endsection