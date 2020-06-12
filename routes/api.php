<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



// buyers

Route::resource('buyers', 'Buyer\BuyerController', ['only' => ['index', 'show']]);

Route::resource('sellers', 'Seller\SellerController', ['except' => ['create', 'edit']]);

Route::resource('products', 'Product\ProductController', ['only' => ['index', 'show']]);

Route::resource('categories', 'Category\CategoryController', ['only' => ['index', 'show']]);

Route::resource('transactions', 'Transaction\TransactionController', ['only' => ['index', 'show']]);

Route::resource('users', 'User\UserController', ['except' => ['create', 'edit']]);

