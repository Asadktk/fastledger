@extends('admin.layout.app')

<style>
    #tbl_exporttable_to_xls {

        margin: 20px auto;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: #fff;
        border: 1px solid #ddd;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        overflow: hidden;
    }

    #tabletop {
        background-color: #e6e6e6;
        color: #555;
        text-align: center;
        padding: 12px;
        font-size: 20px;
        font-weight: bold;
        border-bottom: 2px solid #e6e6e6;
    }

    #tbl_exporttable_to_xls table {
        width: 100%;
        border-collapse: collapse;
    }

    #tbl_exporttable_to_xls th,
    #tbl_exporttable_to_xls td {
        padding: 12px;
        border-bottom: 1px solid #cdcaca;
    }

    #tbl_exporttable_to_xls th {
        background-color: #f4f6f8;
        color: #333;
        text-align: left;
        font-weight: 600;
    }

    #tbl_exporttable_to_xls td {
        color: #555;
        vertical-align: top;
    }

    #tbl_exporttable_to_xls tr:nth-child(even) td {
        background-color: #fafafa;
    }

    #tbl_exporttable_to_xls td:nth-child(3),
    #tbl_exporttable_to_xls th:nth-child(3) {
        text-align: center;
    }

    /* Optional: Hover effect */
    #tbl_exporttable_to_xls tr:hover td {
        background-color: #eef6ff;
    }

    #tbl_exporttable_to_xls tfoot {
        background-color: #c3bfbf;
        /* light grey background */
        color: #555;
        /* dark grey text */
        font-weight: bold;
    }

    #tbl_exporttable_to_xls tfoot td {
        padding: 12px;
        border-top: 2px solid #ccc;
        text-align: center;
    }
</style>

@section('content')
    <div style="margin-top:6%" class="main-content app-content">
        <div class="container-fluid">
            <!-- Page Header -->
            <div class="row">
                <div class="col-xl-12">
                    <div class="card custom-card">
                        <div class="card-header">
                            <h4 class="card-title">Client Cash Book</h4>
                        </div>
                        <div class="card-body">
                            <!-- Filter Form -->
                            <form method="GET" id="filter-form">
                                <div class="mb-4 row">
                                    <div class="col-md-4">
                                        <label for="from_date">From Date:</label>
                                        <input type="date" id="from_date" name="from_date" class="form-control"
                                            value="{{ request('from_date') }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="to_date">To Date:</label>
                                        <input type="date" id="to_date" name="to_date" class="form-control"
                                            value="{{ request('to_date') }}">
                                    </div>
                                    <div class="col-md-4 d-flex align-items-end">

                                        <div class="ms-2">
                                            <button type="submit" id="filter-btn" class="btn btn-primary">Filter</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div id="tbl_exporttable_to_xls">
                                <div id="tabletop">Summary</div>
                                <table class="table table-border table-striped">

                                    <tbody>
                                        <tr>
                                            <th align="left">Item</th>
                                            <th width="90">Box</th>
                                            <th width="60" style="text-align:center">Amount</th>

                                        </tr>
                                        <tr>
                                            <td align="left">VAT due in this period on sales and other output.</td>
                                            <td width="90">1</td>
                                            <td width="60" style="text-align:center">
                                                {{ number_format($_box1Amount, 2) }}</td>


                                        </tr>
                                        <tr>
                                            <td align="left"></td>
                                            <td width="90"></td>
                                            <td width="60" style="text-align:center"></td>

                                        </tr>
                                        <tr>
                                            <td align="left">Vat due in this period on acquisitions from other</td>
                                            <td width="90">2</td>
                                            <td width="60" style="text-align:center">none</td>

                                        </tr>
                                        <tr>
                                            <td align="left">EC Member state</td>
                                            <td width="90"></td>
                                            <td width="60" style="text-align:center"></td>

                                        </tr>
                                        <tr>
                                            <td align="left"></td>
                                            <td width="90"></td>
                                            <td width="60" style="text-align:center"></td>

                                        </tr>
                                        <tr>
                                            <td align="left">Total VAT due</td>
                                            <td width="90">3</td>
                                            <td width="60" style="text-align:center">
                                                {{ number_format($_box1Amount, 2) }}</td>

                                        </tr>
                                        <tr>
                                            <td align="left"></td>
                                            <td width="90"></td>
                                            <td width="60" style="text-align:center"></td>

                                        </tr>
                                        <tr>
                                            <td align="left">VAT reclaimed in this period on purchases and other inputs
                                                (including acquuisitions from EC)</td>
                                            <td width="90">4</td>
                                            <td width="60" style="text-align:center">
                                                {{ number_format($_box4Amount, 2) }}</td>

                                        </tr>

                                        <tr>
                                            <td align="left"></td>
                                            <td width="90"></td>
                                            <td width="60" style="text-align:center"></td>

                                        </tr>
                                        <tr>
                                            <td align="left">Net vat to be paid to customs</td>
                                            <td width="90">5</td>
                                            <td width="60" style="text-align:center">
                                                {{ number_format($_box1Amount - $_box4Amount, 2) }}
                                            </td>

                                        </tr>
                                        <tr>
                                            <td align="left"></td>
                                            <td width="90"></td>
                                            <td width="60" style="text-align:center"></td>

                                        </tr>
                                        <tr>
                                            <td align="left">Total value of sales and all other outputs excluding any VAT.
                                            </td>
                                            <td width="90">6</td>
                                            <td width="60" style="text-align:center">
                                                {{ number_format($_box6Amount, 2) }}</td>

                                        </tr>
                                        <tr>
                                            <td align="left"></td>
                                            <td width="90"></td>
                                            <td width="60" style="text-align:center"></td>

                                        </tr>
                                        <tr>
                                            <td align="left">Total value of purchases and all other inputs excluding any
                                                VAT.</td>
                                            <td width="90">7</td>
                                            <td width="60" style="text-align:center">
                                                {{ number_format($_box7Amount, 2) }}</td>

                                        </tr>
                                        <tr>
                                            <td align="left"></td>
                                            <td width="90"></td>
                                            <td width="60" style="text-align:center"></td>

                                        </tr>
                                        <tr>
                                            <td align="left">Total value of all supplies of goods and related costs,
                                                excluding any VAT, to other EC Member States</td>
                                            <td width="90">8</td>
                                            <td width="60" style="text-align:center">none</td>

                                        </tr>
                                        <tr>
                                            <td align="left"></td>
                                            <td width="90"></td>
                                            <td width="60" style="text-align:center"></td>

                                        </tr>
                                        <tr>
                                            <td align="left">Total value of all acquisitions of goods and related costs.
                                            </td>
                                            <td width="90">9</td>
                                            <td width="60" style="text-align:center">none</td>

                                        </tr>
                                    </tbody>

                                </table><br>



                                <div id="tabletop">Vat Return - Output VAT</div>

                                <table class="table table-border table-striped">
                                    <thead>

                                        <tr>
                                            <th>Date</th>
                                            <th>Ledger Ref</th>
                                            <th>Account Ref</th>
                                            <th>Description</th>
                                            <th style="text-align:center">Net</th>
                                            <th style="text-align:center">VAT</th>
                                            <th style="text-align:center;">Rate</th>
                                        </tr>

                                    </thead>

                                    <tbody>


                                        @foreach ($outputVatDetails as $value)
                                            <tr>
                                                <td>
                                                    {{ \Carbon\Carbon::parse($value['date'])->format('d/m/Y') }}
                                                </td>
                                                <td style="padding: 0 0 0 8px;">
                                                    <a class="ledger-link"
                                                        href="javascript:void(0);">{{ $value['ledger_ref'] }}</a>
                                                </td>
                                                <td>{{ $value['account_ref'] }}</td>

                                                <td>{{ $value['description'] }}</td>
                                                <td align="center">{{ number_format((float) $value['net']) }}</td>
                                                <td align="center">{{ number_format((float) $value['vat']) }}</td>
                                                <td align="center">{{ $value['rate'] }}</td>
                                            </tr>
                                        @endforeach


                                    </tbody>


                                    <tfoot>

                                        <tr>
                                            <td colspan="4" align="right"><strong>Total</strong></td>
                                            <td align="center"><strong>{{ number_format($_box6Amount, 2) }}</strong></td>
                                            <td align="center"><strong>{{ number_format($_box1Amount, 2) }}</strong></td>
                                            <td></td>
                                        </tr>
                                    </tfoot>
                                </table><br>

                                <div id="tabletop">Vat Return - Input VAT</div>
                                <t>Description
                                </t>
                                <table class="table table-border table-striped">

                                    <thead>

                                        <tr>
                                            <th>Date</th>
                                            <th>Ledger Ref</th>
                                            <th>Account Ref</th>
                                            <th>Description</th>
                                            <th style="text-align:center">Net</th>
                                            <th style="text-align:center">VAT</th>
                                            <th style="text-align:center;">Rate</th>
                                        </tr>

                                    </thead>
                                    <tbody>

                                        @foreach ($expenseDetails as $value)
                                            <tr>
                                                <td>
                                                    {{ \Carbon\Carbon::parse($value['date'])->format('d/m/Y') }}
                                                </td>
                                                <td style="padding: 0 0 0 8px;">
                                                    <a class="ledger-link"
                                                        href="javascript:void(0);">{{ $value['ledger_ref'] }}</a>
                                                </td>
                                                <td>{{ $value['account_ref'] }}</td>

                                                <td>{{ $value['description'] }}</td>
                                                <td align="center">{{ number_format((float) $value['net']) }}</td>
                                                <td align="center">{{ number_format((float) $value['vat']) }}</td>
                                                <td align="center">{{ $value['rate'] }}</td>
                                            </tr>
                                        @endforeach


                                    </tbody>

                                    <tfoot>

                                        </tr>
                                        <tr>
                                            <td colspan="4" align="right"><strong>Total</strong></td>
                                            <td align="center"><strong>{{ number_format($_box7Amount, 2) }}</strong></td>
                                            <td align="center"><strong>{{ number_format($_box4Amount, 2) }}</strong></td>
                                            <td></td>
                                        </tr>

                                        <tr>
                                            <td></td>
                                            <td colspan="2">Net VAT to be paid to Customs</td>
                                            <td align="center"><strong></strong></td>
                                            <td align="center">
                                                <strong>{{ number_format($_box1Amount - $_box4Amount, 2) }}
                                                </strong>
                                            </td>
                                        </tr>
                                    </tfoot>




                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
