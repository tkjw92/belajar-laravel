<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class BorrowedModel extends Model
{
    protected $appends = ['name'];

    public function getNameAttribute()
    {
        return User::find($this->id_user)?->name ?? '-';
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('d F Y H:i:s');
    }

    public function getReturnAtAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('d F Y H:i:s') : '-';
    }
}
