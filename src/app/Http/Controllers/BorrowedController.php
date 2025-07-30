<?php

namespace App\Http\Controllers;

use App\Models\BooksModel;
use App\Models\BorrowedModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BorrowedController extends Controller
{
    public function getHistoryByBook($id)
    {
        $history = BorrowedModel::where('id_book', $id)->orderBy('created_at', 'DESC')->get();

        return response()->json($history);
    }

    public function borrowBook($id)
    {
        $user = Auth::user();
        $book = BooksModel::find($id);

        if (! $book) {
            return redirect(route('login'));
        }

        if (BorrowedModel::whereIdUser($user->id)->whereIdBook($book->id)->whereReturnAt(null)->count()) {
            return back()->with('error_body', "You haven't returned this book yet.");
        }

        BorrowedModel::create([
            'id_book' => $book->id,
            'id_user' => $user->id
        ]);

        return back();
    }

    public function borrowed()
    {
        $borrowed = BorrowedModel::whereIdUser(Auth::id())->whereReturnAt(null)->pluck('id_book');
        $books = BooksModel::whereIn('id', $borrowed)->get();

        return view('pages.borrowed', compact('books'));
    }

    public function returnBook($id)
    {
        $book = BooksModel::find($id);

        if (! $book) {
            return back()->with('error_body', 'Book is not found !!!');
        }

        BorrowedModel::whereIdBook($book->id)->whereIdUser(Auth::id())->whereReturnAt(null)->update([
            'return_at' => now()
        ]);

        return back();
    }
}
