@extends('admin.layout.app')

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
                                    <input type="date" id="from_date" name="from_date" class="form-control" value="{{ request('from_date') }}">
                                </div>
                                <div class="col-md-4">
                                    <label for="to_date">To Date:</label>
                                    <input type="date" id="to_date" name="to_date" class="form-control" value="{{ request('to_date') }}">
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
                                                    <td width="60" style="text-align:center">0</td>
                                                   
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
                                                    <td width="60" style="text-align:center">0</td>
                                                   
                                                </tr>
                                                <tr>
                                                    <td align="left"></td>
                                                    <td width="90"></td>
                                                    <td width="60" style="text-align:center"></td>
                                                   
                                                </tr>
                                                <tr>
                                                    <td align="left">VAT reclaimed in this period on purchases and other inputs (including acquuisitions from EC)</td>
                                                    <td width="90">4</td>
                                                    <td width="60" style="text-align:center">0</td>
                                                   
                                                </tr>
                                                
                                                <tr>
                                                    <td align="left"></td>
                                                    <td width="90"></td>
                                                    <td width="60" style="text-align:center"></td>
                                                   
                                                </tr>
                                                <tr>
                                                    <td align="left">Net vat to be paid to customs</td>
                                                    <td width="90">5</td>
                                                    <td width="60" style="text-align:center">0</td>
                                                   
                                                </tr>
                                                <tr>
                                                    <td align="left"></td>
                                                    <td width="90"></td>
                                                    <td width="60" style="text-align:center"></td>
                                                   
                                                </tr>
                                                <tr>
                                                    <td align="left">Total value of sales and all other outputs excluding any VAT.</td>
                                                    <td width="90">6</td>
                                                    <td width="60" style="text-align:center">0</td>
                                                   
                                                </tr>
                                                <tr>
                                                    <td align="left"></td>
                                                    <td width="90"></td>
                                                    <td width="60" style="text-align:center"></td>
                                                   
                                                </tr>
                                                <tr>
                                                    <td align="left">Total value of purchases and all other inputs excluding any VAT.</td>
                                                    <td width="90">7</td>
                                                    <td width="60" style="text-align:center">0</td>
                                                   
                                                </tr>
                                                <tr>
                                                    <td align="left"></td>
                                                    <td width="90"></td>
                                                    <td width="60" style="text-align:center"></td>
                                                   
                                                </tr>
                                                <tr>
                                                    <td align="left">Total value of all supplies of goods and related costs, excluding any VAT, to other EC Member States</td>
                                                    <td width="90">8</td>
                                                    <td width="60" style="text-align:center">none</td>
                                                   
                                                </tr>
                                                <tr>
                                                    <td align="left"></td>
                                                    <td width="90"></td>
                                                    <td width="60" style="text-align:center"></td>
                                                   
                                                </tr>
                                                <tr>
                                                    <td align="left">Total value of all acquisitions of goods and related costs.</td>
                                                    <td width="90">9</td>
                                                    <td width="60" style="text-align:center">none</td>
                                                   
                                                </tr>
                                            </tbody>
                            
                                        </table><br>
                                        
                                        
                                        
                                        <div id="tabletop">Vat Return - Output VAT</div>
                            
                                        <table  class="table table-border table-striped">
                            
                                            <tbody>
                            
                                                <tr>
                                                    <th style="text-align: center;">Date</th>
                                                    <th>Ledger Ref</th>
                                                    <th>Account Ref</th>
                                                    <th>Description</th>
                                                    <th style="text-align:center">Net</th>
                                                    <th style="text-align:center">VAT</th>
                                                    <th style="text-align:center;">Rate</th>
                                                </tr>
                            
                                                                </tbody>
                            
                                        </table><br>
                            
                                        <div id="tabletop">Vat Return - Input VAT</div>
                                        <t>Description
                                                    </t><table   class="table table-border table-striped">
                            
                                            <tbody>
                            
                                                <tr>
                                                    <th style="text-align: center;">Date</th>
                                                    <th>Ledger Ref</th>
                                                    <th>Account Ref</th>
                                                    <th style="text-align:center">Net</th>
                                                    <th style="text-align:center">VAT</th>
                                                    <th style="text-align:center;">Rate</th>
                                                </tr>
                                            
                            
                                                                    <tr>
                                                    <td colspan="4"></td>
                                                    <td align="center"><strong>0.00</strong></td>
                                                    <td align="center"><strong>0.00</strong></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                            
                                                    <td colspan="6" style="text-align: center;"><b>&nbsp;</b></td>
                            
                                                    <td style="text-align: center; padding: 0 50px 0 0;"><b>&nbsp;</b></td>
                            
                                                    <td>&nbsp;</td>
                            
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td colspan="3">Total input VAT</td>
                                                    <td align="center"><strong>0.00</strong></td>
                                                    <td align="center"><strong>0.00</strong></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                            
                                                    <td colspan="6" style="text-align: center;"><b>&nbsp;</b></td>
                            
                                                    <td style="text-align: center; padding: 0 50px 0 0;"><b>&nbsp;</b></td>
                            
                                                    <td>&nbsp;</td>
                            
                                                </tr>
                                                                    <tr>
                                                    <td></td>
                                                    <td colspan="2">Net VAT to be paid to Customs</td>
                                                    <td align="center"><strong></strong></td>
                                                    <td align="center">                        
                                                    <strong>0.00</strong></td>
                                                </tr>
                                                                    
                                            </tbody>
                            
                                        </table>
                                        
                                        </div>
                    </div>
              </div>
         </div>
     </div>
 </div>