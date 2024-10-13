<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// login route
Route::get('/login', [AdminController::class, 'login'])->name('login'); //✅
Route::post('/login', [AdminController::class, 'login_check'])->name('login.check'); //✅

Route::middleware(['admin'])->group(function () {
    Route::get('/logout', [AdminController::class, 'logout'])->name('logout'); //✅
    
    // dashboard
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');

    // products routes  
    Route::get('/products', [AdminController::class, 'getProducts'])->name('products.list');
    // Route::get('/all-products', [AdminController::class, 'all_products'])->name('all.products');
    Route::get('/product/{id}', [AdminController::class, 'view_product'])->name('view.product');
    Route::post('/product', [AdminController::class, 'store_product'])->name('store.product');
    Route::get('/edit-product/{id}', [AdminController::class, 'get_product'])->name('edit.product.get');
    Route::post('/edit-product/{id}', [AdminController::class, 'edit_product'])->name('edit.product');
    Route::delete('/delete-product/{id}', [AdminController::class, 'delete_product'])->name('delete.product');
});
