<?php

use App\DataTables\FeeEarnerDataTable;
use App\Http\Controllers\FeeEarnersController;
 

use App\Http\Controllers\Report\FileOpeningBookReportController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\MatterController;
use App\Http\Controllers\DayBookController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ClientCashBookController;
use App\Http\Controllers\Report\OfficeCashBookController;
use App\Http\Controllers\Report\BillOfCostReportController;
use App\Http\Controllers\Report\ClientLedgerReportController;

use App\Http\Controllers\Report\FileOpeningBookReportController;
use App\Http\Controllers\Report\ClientBankReconciliationController;
use App\Http\Controllers\Report\OfficeBankReconciliationController;
use App\Http\Controllers\Report\ClientLedgerBalanceReportController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return view('admin.home');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::get('/files', [FileController::class, 'index'])->name('files.index');
Route::get('/files/create', [FileController::class, 'create'])->name('files.create');
Route::get('/file/update/{id}', [FileController::class, 'getdata'])->name('update.file');

Route::post('/files', [FileController::class, 'store']);



Route::post('/files/update', [FileController::class, 'update_file_recode'])->name('files.update');


Route::post('/files', [FileController::class, 'store']);
Route::post('/files/delete_id', [FileController::class, 'destroy'])->name('files.destroy');
Route::post('/files/get-filedata', [FileController::class, 'getFileData'])->name('files.get.filedata');

Route::post('/files/update-status', [FileController::class, 'updateStatus'])->name('files.update.status');

Route::get('/matters/{id}/submatters', [MatterController::class, 'getSubMatters'])->name('matters.submatters');

Route::get('/archived', [ClientController::class, 'archivedClients'])->name('clients.archived'); // Show archived clients

Route::prefix('transactions')
    ->name('transactions.')
    ->controller(DayBookController::class)
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/{transaction}/edit', 'edit')->name('edit');
        Route::get('/import/{id}', 'import')->name('import');
        Route::post('/get-payment-types', 'getPaymentTypes')->name('payment.types');
        Route::post('/get-account-ref', 'getAccountRef')->name('account.ref');
        Route::post('/get-vat-types', 'getVatTypes');
        Route::get('/get-account-details/{id}', 'getAccountDetails');
    });


Route::get('/transaction_imported', [TransactionController::class, 'index'])->name('transactions.imported');
Route::delete('/transactions/{id}/delete', [TransactionController::class, 'destroy'])->name('transactions.destroy');
Route::get('client-cash-book', [ClientCashBookController::class, 'index'])->name('client.cashbook');
Route::get('file-opening-book', [FileOpeningBookReportController::class, 'index'])->name('file.report');
Route::get('file-opening-book/data', [FileOpeningBookReportController::class, 'getData'])->name('file.report.data');
Route::get('/file/report/pdf', [FileOpeningBookReportController::class, 'downloadPDF'])->name('file.report.pdf');
Route::get('/file/report/csv', [FileOpeningBookReportController::class, 'downloadCSV'])->name('file.report.csv');

Route::get('/report/client-ledger-by-balance', [ClientLedgerBalanceReportController::class, 'index'])->name('client.passed.check');
Route::get('/report/client-ledger', [ClientLedgerReportController::class, 'index'])->name('client.ledger');
Route::get('/report/client-ledgers', [ClientLedgerReportController::class, 'getdata'])->name('client.ledger.data');
Route::get('/report/client-ledger-data', [ClientLedgerReportController::class, 'index'])->name('client.ledgers');

Route::get('/report/bill-of-cost', [BillOfCostReportController::class, 'index'])->name('bill.of.cost');


Route::get('/search-ledger', [BillOfCostReportController::class, 'search'])->name('search.ledger');
Route::get('/report/bill-of-cost-search', [BillOfCostReportController::class, 'get_data'])->name('bill.of.cost.data');
Route::get('/report/vat-report', [VatReportController::class, 'index'])->name('vat.report');

Route::get('/fee-earners', [FeeEarnersController::class, 'index'])->name('fee.earners');
Route::get('/add-fee-earner', [FeeEarnersController::class, 'create'])->name('feeearner.create');

Route::post('/feeearner/sotre', [FeeEarnersController::class, 'store'])->name('feeearner.store');

Route::get('/active-fee-earners', [FeeEarnersController::class, 'checkactive'])->name('check.active');
Route::get('/inactive-fee-earners', [FeeEarnersController::class, 'checkinactive'])->name('check.inactive');
Route::post('/inactives-fee-earners', [FeeEarnersController::class, 'updatefeeernerstatus'])->name('update.feeerner.status');

Route::get('/edit-Feeearner/{id}', [FeeEarnersController::class, 'edit'])->name('user.edit');

Route::post('/feeearner/update/{id}', [FeeEarnersController::class, 'update'])->name('feeearner.update');


Route::put('/feeearner/update/{id}', 'FeeEarnerController@update')->name('feeearner.update');

Route::get('client-cash-book/initial-balance', [ClientCashBookController::class, 'getInitialBalance'])
    ->name('client.cashbook.get_initial_balance');
Route::get('office-cash-book', [OfficeCashBookController::class, 'index'])->name('office.cashbook');
Route::get('office-cash-book/initial-balance', [OfficeCashBookController::class, 'getInitialBalance'])
    ->name('office.cashbook.get_initial_balance');

Route::get('client-bank-reconciliation', [ClientBankReconciliationController::class, 'index'])
    ->name('client.bank_bank_reconciliation');
Route::get('fetch-client-bank-reconciliation/{date}', [ClientBankReconciliationController::class, 'fetchBankReconciliation'])
    ->name('client.bank.reconciliation.fetch');
Route::get('/client-bank-reconciliation/pdf/{date}', [ClientBankReconciliationController::class, 'exportPdf']);

Route::get('office-bank-reconciliation', [OfficeBankReconciliationController::class, 'index'])
    ->name('office.bank_reconciliation');
Route::get('/office-bank-reconciliation/data', [OfficeBankReconciliationController::class, 'getData'])
    ->name('Office.bank_reconciliation.data');
Route::get('/Office/bank_reconciliation.initial_balance', [OfficeBankReconciliationController::class, 'getInitialBalance'])
    ->name('Office.bank_reconciliation.initial_balance');
Route::get('/download-pdf/data', [OfficeBankReconciliationController::class, 'downloadPDF'])
    ->name('generate.pdf');

Route::get('client-bank-reconciliation', [ClientBankReconciliationController::class, 'index'])->name('client.bank_bank_reconciliation');
Route::get('fetch-client-bank-reconciliation', [ClientBankReconciliationController::class, 'fetchBankReconciliation'])->name('client.bank_reconciliation');
Route::prefix('clients')
    ->name('clients.')
    ->controller(ClientController::class)
    ->middleware('role:admin')
    ->group(function () {
        Route::get('create', 'create')->name('create');
        Route::get('/{type?}', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::get('/{client}', 'show')->name('show');
        Route::put('/{client}', 'update')->name('update');
        Route::delete('/{client}', 'destroy')->name('destroy');
        Route::put('/{client}/archive', 'archive')->name('archive');
    });


require __DIR__ . '/auth.php';
