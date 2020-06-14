<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



// buyers

Route::resource('buyers', 'Buyer\BuyerController', ['only' => ['index', 'show']]);

Route::resource('buyers.transactions', 'Buyer\BuyerTransactionController', ['only' => ['index']]);

Route::resource('buyers.products', 'Buyer\BuyerProductController', ['only' => ['index']]);

Route::resource('sellers', 'Seller\SellerController', ['except' => ['create', 'edit']]);

Route::resource('products', 'Product\ProductController', ['only' => ['index', 'show']]);

Route::resource('categories', 'Category\CategoryController', ['except' => ['create', 'edit']]);

Route::resource('transactions', 'Transaction\TransactionController', ['only' => ['index', 'show']]);

Route::resource('transactions.categories', 'Transaction\TransactionCategoryController', ['only' => ['index']]);

Route::resource('transactions.sellers', 'Transaction\TransactionSellerController', ['only' => ['index']]);

Route::resource('users', 'User\UserController', ['except' => ['create', 'edit']]);

