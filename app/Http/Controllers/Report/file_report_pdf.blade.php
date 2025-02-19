<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Report</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
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
    <h2 style="text-align: center;">File Opening Book Report</h2>
    <h4>From: {{ date('d/m/Y', strtotime($fromDate)) }} | To: {{ date('d/m/Y', strtotime($toDate)) }}</h4>

    <table>
        <thead>
            <tr>
                <th>S/No</th>
                <th>File Open Date</th>
                <th>Ledger Ref</th>
                <th>Matter</th>
                <th>Client Name</th>
                <th>Address</th>
                <th>Fee Earner</th>
                <th>Status</th>
                <th>Close Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $index => $record)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ date('d/m/Y', strtotime($record->File_Date)) }}</td>
                    <td>{{ $record->Ledger_Ref }}</td>
                    <td>{{ $record->Matter }}</td>
                    <td>{{ $record->First_Name }} {{ $record->Last_Name }}</td>
                    <td>{{ $record->Address1 }} {{ $record->Address2 }} {{ $record->Town }} {{ $record->Post_Code }}</td>
                    <td>{{ $record->Fee_Earner }}</td>
                    <td>{{ $record->Status }}</td>
                    <td>{{ date('d/m/Y', strtotime($record->File_Date)) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
