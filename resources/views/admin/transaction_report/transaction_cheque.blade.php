@extends('admin.layout.app')

@section('content')
    @extends('admin.partial.errors')
    <div class="main-content app-content">
        <div class="container-fluid">
            <!-- Page Header -->
            <div class="row">
                <div class="col-xl-12">
                    <div class="card custom-card">
                        <div class="card-header d-flex justify-content-between">
                            <h4 class="card-title">Transaction Report</h4>
                            <div>
                                <a href="{{ route('transactions.create') }}" class="btn btnstyle rounded-pill btn-wave"
                                    role="button">Add New</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Transaction Date</th>
                                            <th>Ledger Ref</th>
                                            <th>Bank Account (Type)</th>
                                            <th>Paid In/Out</th>
                                            <th>Reference</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($transactions as $transaction)
                                            <tr>
                                                <td>{{ \Carbon\Carbon::parse($transaction->Transaction_Date)->format('Y-m-d') }}
                                                </td>
                                                <td>{{ $transaction->file->Ledger_Ref ?? '' }}</td>
                                                <td>{{ $transaction->Bank_Account_Name ?? '' }}</td>
                                                <td>
                                                    @if ($transaction->Paid_In_Out == 1)
                                                        Paid In
                                                    @elseif ($transaction->Paid_In_Out == 2)
                                                        Paid Out
                                                    @else
                                                        {{ $transaction->Paid_In_Out }}
                                                    @endif
                                                </td>
                                                <td>{{ $transaction->Reference ?? '' }}</td>
                                                <td>
                                                    <!-- Form for dynamic amount and date -->
                                                    <form action="{{ route('bank.cheque.save') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="transaction_id"
                                                            value="{{ $transaction->Transaction_ID }}">
                                                        <input type="hidden" name="transaction_type" value="2">

                                                        <div class="form-group">
                                                            <input type="text" name="amount"
                                                                value="{{ old('amount', $transaction->Amount) }}"
                                                                class="form-control" placeholder="Enter amount">
                                                        </div>
                                                        <div class="form-group">
                                                            <input type="date" name="transaction_date"
                                                                value="{{ old('transaction_date', \Carbon\Carbon::parse($transaction->Transaction_Date)->format('Y-m-d')) }}"
                                                                class="form-control" placeholder="Select date">
                                                        </div>
                                                        <button type="submit" class="btn btn-sm btn-success"
                                                            id="saveButton-{{ $transaction->Transaction_ID }}"
                                                            @if ($transaction->bankReconciliation) disabled @endif>
                                                            {{ $transaction->bankReconciliation ? 'Saved' : 'Save' }}
                                                        </button>
                                                    </form>

                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>

                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            const saveButton = document.getElementById('saveButton');

            if (form && saveButton) {
                form.addEventListener('submit', function() {
                    saveButton.disabled = true;
                    saveButton.innerText = 'Saving...';
                });
            }
        });
    </script>
@endsection
