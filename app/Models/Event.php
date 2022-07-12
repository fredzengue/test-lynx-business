<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'date'];

    public function scopeFilterDate($query, $date)
    {
        return $query->whereBetween('date', $date);
    }
}
