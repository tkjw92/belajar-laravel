<?php

use App\Http\Controllers\AccountsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BooksController;
use App\Http\Controllers\BorrowedController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'loginPage'])->name('login');

route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::post('/', [AuthController::class, 'login']);

// Require Login to Access
Route::middleware('auth')->group(function () {

    // Only accept who have role type admin
    Route::middleware('admin')->group(function () {
        Route::post('/books/add', [BooksController::class, 'add'])->name('books.add');
        Route::post('/books/edit', [BooksController::class, 'edit'])->name('books.edit');
        Route::post('/books/delete', [BooksController::class, 'delete'])->name('books.delete');

        Route::get('/accounts', [AccountsController::class, 'index'])->name('accounts');
        Route::get('/accounts/get/{id}', [AccountsController::class, 'get'])->name('accounts.get');
        Route::post('/accounts/add', [AccountsController::class, 'add'])->name('accounts.add');
        Route::post('/accounts/edit', [AccountsController::class, 'edit'])->name('accounts.edit');
        Route::post('/accounts/delete', [AccountsController::class, 'delete'])->name('accounts.delete');
    });

    // General users access
    Route::get('/books', [BooksController::class, 'index'])->name('books');
    Route::get('/books/get/{id}', [BooksController::class, 'get'])->name('books.get');

    Route::get('/books/borrowed', [BorrowedController::class, 'borrowed'])->name('books.borrowed');
    Route::get('/books/return/{id}', [BorrowedController::class, 'returnBook'])->name('books.return');

    Route::get('/borrow/{id}', [BorrowedController::class, 'borrowBook'])->name('borrow');
    Route::get('/borrow/history/book/{id}', [BorrowedController::class, 'getHistoryByBook'])->name('borrow.history.by.book');
});
