<?php

namespace App\Http\Controllers;

use App\Models\BooksModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\File;

class BooksController extends Controller
{
    public function index(Request $request)
    {
        if ($request->search) {
            $books = BooksModel::whereLike('title', '%' . $request->search . '%')->orderBy('created_at', 'DESC')->get();
        } else {
            $books = BooksModel::orderBy('created_at', 'DESC')->get();
        }

        return view('pages.books', compact('books', 'request'));
    }

    public function get($id)
    {
        $book = BooksModel::find($id);

        if (! $book) {
            return redirect(route('login'));
        }

        return response()->json($book);
    }

    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
            'counts' => 'required|numeric|min:1',
            'cover' => [
                'required',
                File::image()->max(1024 * 2)
            ]
        ]);

        if ($validator->fails()) {
            return back()->with('error_add', true)->withInput()->withErrors($validator);
        }

        // Handle File
        $path = $request->file('cover')->store('covers');

        // Handle Data
        $book = BooksModel::create([
            'title' => $request->title,
            'description' => $request->description,
            'counts' => $request->counts,
            'cover' => $path
        ]);

        if ($book) {
            return back()->with('status', 'success');
        }

        return back()->with('error_add', true)->withInput();
    }

    public function edit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
            'counts' => 'required|numeric|min:1',
            'cover' => [
                'nullable',
                File::image()->max(1024 * 2)
            ]
        ]);

        $book = BooksModel::find($request->id);

        if (! $book) {
            return back();
        }

        if ($validator->fails()) {
            return back()->with('error_edit', true)->withInput()->withErrors($validator);
        }

        // Check if cover updated
        if ($request->file('cover')) {
            $path = $request->file('cover')->store('covers');
            Storage::delete($book->cover);

            $book->update([
                'cover' => $path
            ]);
        }

        // Handle data
        $book->update([
            'title' => $request->title,
            'description' => $request->description,
            'counts' => $request->counts
        ]);

        if ($book) {
            return back()->with('status', 'success');
        }

        return back()->with('error_edit', true)->withInput();
    }

    public function delete(Request $request)
    {
        $request->validate(['id' => 'required']);

        $book = BooksModel::find($request->id);

        if ($book) {
            $book->delete();
        }

        return back();
    }
}
