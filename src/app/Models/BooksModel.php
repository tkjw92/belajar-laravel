<?php

namespace App\Models;

use Database\Factories\BooksFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BooksModel extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return BooksFactory::new();
    }

    public function getAvailableAttribute()
    {
        $current = $this->counts;
        $borrowed = BorrowedModel::whereIdBook($this->id)->whereReturnAt(null)->count();

        return $current - $borrowed;
    }
}
