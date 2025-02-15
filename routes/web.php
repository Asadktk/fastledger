<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\MatterController;
use App\Http\Controllers\DayBookController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;

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
Route::post('/files', [FileController::class, 'store']) ;
 
Route::post('/files/delete_id', [FileController::class, 'destroy'])->name('files.destroy');
Route::post('/files/get-filedata', [FileController::class, 'getFileData'])->name('files.get.filedata');

Route::post('/files/update-status', [FileController::class, 'updateStatus'])->name('files.update.status');

Route::get('/matters/{id}/submatters', [MatterController::class, 'getSubMatters'])->name('matters.submatters');

Route::get('/archived', [ClientController::class, 'archivedClients'])->name('clients.archived'); // Show archived clients

// Route::get('/transactions', [DayBookController::class, 'index'])->name('transactions.index');
// Route::get('/transactions/create', [DayBookController::class, 'create'])->name('transactions.create');
// Route::post('/transactionStore', [DayBookController::class, 'store'])->name('transactions.store');
// Route::get('/transaction/get-account-details/{id}', [DayBookController::class, 'getAccountDetails']);
// Route::post('/transactions/get-payment-types', [DayBookController::class, 'getPaymentTypes'])
//     ->name('transactions.payment.types');
// Route::post('/transactions/get-account-ref', [DayBookController::class, 'getAccountRef'])
//     ->name('account.ref');
// Route::post('/get-vat-types', [DayBookController::class, 'getVatTypes']);
// Route::get('/transactions/import/{id}', [DayBookController::class, 'import'])->name('transactions.import');

Route::prefix('transactions')
    ->name('transactions.')
    ->controller(DayBookController::class)
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/import/{id}', 'import')->name('import');
        Route::post('/get-payment-types', 'getPaymentTypes')->name('payment.types');
        Route::post('/get-account-ref', 'getAccountRef')->name('account.ref');
        Route::post('/get-vat-types', 'getVatTypes');
        Route::get('/get-account-details/{id}', 'getAccountDetails');
    });


Route::get('/transaction_imported', [TransactionController::class, 'index'])->name('transactions.imported');
Route::delete('/transactions/{id}/delete', [TransactionController::class, 'destroy'])->name('transactions.destroy');


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
