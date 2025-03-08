<!DOCTYPE html>
<html>

<head>
    <title>Office Bank Reconciliation Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <h2>Bank Reconciliation (Office Account) for the month of October 2014</h2>
    <p><strong>Bank Account ID:</strong> {{ $bankAccountId }}</p>
    <p><strong>Initial Balance:</strong> {{ number_format($initialBalance, 2) }}</p>

    @php
        $sections = [
            'book_ledger' => 'Book Ledger',
            'disbursments' => 'Disbursements',
            'sales_book' => 'Sales Book',
            'payment_refund' => 'Payment Refund',
            'payment_transfer' => 'Payment Transfer',
            'miscellaneous' => 'Miscellaneous',
        ];
    @endphp

    @foreach ($sections as $key => $title)
        @if (!empty($banks[$key]))
            <h3>{{ $title }}</h3>
            <table border="1" cellspacing="0" cellpadding="5">
                <thead>
                    <tr>
                        <th>Ledger Ref</th>
                        <th>Amount</th>
                        <th>Cheque</th>
                        <th>Client Name</th>
                        <th>Account Ref Description</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($banks[$key] as $bank)
                        <tr>
                            <td>{{ $bank->Ledger_Ref ?? 'N/A' }}</td>
                            <td>{{ number_format($bank->Amount ?? 0, 2) }}</td>
                            <td>{{ $bank->Cheque ?? 'N/A' }}</td>
                            <td>{{ $bank->Client_Name ?? 'N/A' }}</td>
                            <td>{{ $bank->AccountRefDescription ?? 'N/A' }}</td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
        @endif
    @endforeach
</body>

</html>
