<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\PriceController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\StatsController;
use App\Http\Controllers\DepartamentoController;
use App\Http\Controllers\TshirtImageController;
use App\Http\Controllers\Auth\ChangePasswordController;
use Illuminate\Support\Facades\Auth;

Route::view('/', 'home')->name('root');
Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


//Ttshirts
Route::resource('tshirtImage', TshirtImageController::class);

Route::get('/tshirt/',[TshirtImageController::class,'indexAdmin'])->name('tshirt.indexAdmin');

Route::get('/tshirt/create', [TshirtImageController::class, 'createAdmin'])->name('tshirt.createAdmin');

Route::post('/tshirt/',[TshirtImageController::class,'storeAdmin'])->name('tshirt.storeAdmin');

Route::get('/tshirt/{tshirtImage}',[TshirtImageController::class,'editAdmin'])->name('tshirt.editAdmin');

Route::patch( '/tshirt/{tshirtImage}',[TshirtImageController::class,'updateAdmin'])->name('tshirt.updateAdmin');

Route::delete('/tshirt/{tshirtImage}', [TshirtImageController::class, 'destroyAdmin'])->name('tshirt.destroyAdmin');

Route::get('/tshirts/{tshirtImage}/img', [TshirtImageController::class, 'getPrivateImg'])->name('tshirts.private');

Auth::routes(['verify' => true]);
Route::middleware(['auth', 'verified'/*,isBlocked*/])->group(function () {
    Route::get('/password/change', [ChangePasswordController::class, 'show'])
        ->name('password.change.show');
    Route::post('/password/change', [ChangePasswordController::class, 'store'])
        ->name('password.change.store');
});

//Categories
Route::resource('category',CategoryController::class);

//Customer
Route::resource('customer',CustomerController::class);

//Preco
Route::resource('price', PriceController::class);

//Colors
Route::resource('color',ColorController::class);


//Users
Route::get('/users/admin', [UserController::class, 'index'])->name('users.index');
Route::patch('/users/{user}/block', [UserController::class, 'block'])->name('users.block');
Route::resource('user', UserController::class);


// CART
//mostrar carrinho
Route::get('/cart', [CartController::class,'show'])->name('cart.show');
//adicionar ao carrinho
Route::post('cart/{tshirtImage}', [CartController::class, 'addToCart'])->name('cart.add');
//remover do carrinho
Route::delete('cart/{tshirtImage}/{color}/{tamanho}', [CartController::class, 'removeFromCart'])->name('cart.remove');
//limpar carrinho
Route::delete('cart', [CartController::class, 'destroy'])->name('cart.destroy');
//update item do carrinho
Route::patch('/cart/{tshirtImage}/{color}/{tamanho}', [CartController::class, 'update'])->name('cart.update');
//editar
Route::get('/cart/{tshirtImage}/{color}/{tamanho}/edit', [CartController::class, 'edit'])->name('cart.edit');

// Payment
Route::get('/cart/pay', [CartController::class, 'pay'])->name('cart.pay');

// Encomendas
//Order Index Page
Route::resource('order', OrderController::class);
Route::get('/orders/{order}/pdf', [OrderController::class, 'showReceipt'])->name('orders.pdf');


// Statistics
Route::resource('stats', StatsController::class);


//Login
Route::view('/login', 'auth.login')->name('login');


