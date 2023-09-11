<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Inward;
use App\Http\Controllers\Outward;
use App\Http\Controllers\User;
use App\Http\Controllers\Items;
use App\Http\Controllers\Supplier;
use App\Http\Controllers\Customer;
use App\Http\Controllers\Reports;
use App\Http\Controllers\loginController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::post('addUser',[loginController::class,'addUser']);
Route::post('validateUser',[loginController::class,'validateUser']);
Route::get('logout',[loginController::class,'logout']);
Route::view('/','login');
Route::view('home','home');
Route::view('register','register');

Route::get('showInwardForm',[Inward::class,'showInwardForm']);
Route::post('addInward',[Inward::class,'addInward']);
Route::post('loadInwardList',[Inward::class,'loadInwardList']);
Route::post('deleteInward',[Inward::class,'deleteInward']);
Route::post('loadEditRecord',[Inward::class,'loadEditRecord']);
Route::post('updateInward',[Inward::class,'updateInward']);
Route::post('getItemsSupplierBase',[Inward::class,'getItemsSupplierBase']);



//Item master routes

Route::get('addItems',[Items::class,'addItems']);
Route::post('insertItems',[Items::class,'insertItems']);
Route::post('loadItemsList',[Items::class,'loadItemsList']);
Route::post('deleteItems',[Items::class,'deleteItems']);
Route::post('loadEditItem',[Items::class,'loadEditItem']);
Route::post('updateItem',[Items::class,'updateItem']);

//Supplier master routes

Route::get('supplierForm',[Supplier::class,'showSupplierForm']);
Route::post('addSuppiler',[Supplier::class,'addSuppiler']);
Route::post('loadSupplierList',[Supplier::class,'loadSupplierList']);
Route::post('loadEditSupplier',[Supplier::class,'loadEditSupplier']);
Route::post('updateSupplier',[Supplier::class,'updateSupplier']);
Route::post('deleteSupplier',[Supplier::class,'deleteSupplier']);

//User master
Route::get('addUserForm',[User::class,'showUserForm']);
Route::post('addNewUser',[User::class,'addNewUser']);
Route::post('loadUserList',[User::class,'loadUserList']);
Route::post('loadEditUser',[User::class,'loadEditUser']);
Route::post('updateUser',[User::class,'updateUser']);
Route::post('deleteUser',[User::class,'deleteUser']);

//Outward

Route::get('showOutwardForm',[Outward::class,'showOutwardForm']);
Route::post('addOutward',[Outward::class,'addOutward']);
Route::post('editOutward',[Outward::class,'editOutward']);
Route::post('loadOutwardList',[Outward::class,'loadOutwardList']);
Route::post('loadOneOutward',[Outward::class,'loadOneOutward']);
Route::post('updateOutward',[Outward::class,'updateOutward']);
Route::post('deleteOutward',[Outward::class,'deleteOutward']);

//Supplier master routes

Route::get('customerForm',[Customer::class,'showCustomerForm']);
Route::post('addCustomer',[Customer::class,'addCustomer']);
Route::post('loadCustomerList',[Customer::class,'loadCustomerList']);
Route::post('loadEditCustomer',[Customer::class,'loadEditCustomer']);
Route::post('updateCustomer',[Customer::class,'updateCustomer']);
Route::post('deleteCustomer',[Customer::class,'deleteCustomer']);

//Reports

Route::get('showInwardReportForm',[Reports::class,'showInwardReport']);
Route::post('purchaseReport',[Reports::class,'getPurchaseReport']);

Route::get('showOutwardReportForm',[Reports::class,'showOutwardReportForm']);
Route::post('OutwardReport',[Reports::class,'getOutwardReport']);

Route::get('stockList',[Reports::class,'stockListForm']);
Route::post('stockReport',[Reports::class,'stockReport']);

Route::get('showItemList',[Reports::class,'showItemList']);
Route::post('showItemListReport',[Reports::class,'getItemList']);


Route::get('showChatForum',[Reports::class,'showChatForum']);
