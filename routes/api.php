<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\LaundryCategoryController;
use App\Http\Controllers\TransactionDetailsController;

// Route::get('/', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::get('/', function () {
    return "API";
});


Route::post('/register', [AuthController::class, "register"]);

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
// Route::middleware('auth:sanctum')->get('/staff', function (Request $request) {
//     return $request->user();
// });

Route::get('displayincome', [AuthController::class, 'displayincome']);

Route::post('/login',[AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return response()->json($request->user());
    });
    Route::post('/custSignup', [CustomerController::class, 'store']);
    Route::get('/custDisplay', [CustomerController::class, 'index']);
    Route::get('/getCustShow/{id}', [CustomerController::class, 'show']);
    Route::post('/custHistAdd', [TransactionController::class, 'store']);
    Route::get('/getCustHist/{id}', [TransactionController::class, 'show']);
    Route::get('/Transaction', [TransactionController::class, 'index']);
    Route::post('/addExp', [ExpenseController::class, 'store']);
    Route::get('/dispListExp', [ExpenseController::class, 'index']);
    Route::post('/uploadExpImg', [ExpenseController::class, 'upload']);
    Route::get('/getExpReceipt/{id}', [ExpenseController::class, 'show']);
    Route::post('/addCateg', [LaundryCategoryController::class, 'store']);
    Route::post('addTransCust', [TransactionDetailsController::class, 'storeTransCust']);
    Route::post('addTransDetCust', [TransactionDetailsController::class, 'storeTransDetCust']);
    Route::get('getTransCust/{id}', [TransactionController::class, 'showTransCust']);
    Route::get('getAddService/{id}', [TransactionController::class, 'getAddService']);
    Route::get('getLaundryDetails/{id}', [TransactionController::class, 'showLaundryDetails']);
    Route::post('saveLaundryDetails', [TransactionController::class, 'saveLaundryDetails']);
    Route::get('totalPrice/{id}', [TransactionController::class, 'totalPrice']);
    Route::get('getCash/{id}', [TransactionController::class, 'getCash']);
    Route::post('addRem', [TransactionController::class, 'addRem']);
    Route::post('submitLaundryTrans/{id}', [TransactionController::class, 'submitLaundryTrans']);
    Route::post('updateStatus/{id}', [TransactionController::class, 'updateStatus']);
    Route::post('doneTransac/{id}', [TransactionController::class, 'doneTransac']);
});

