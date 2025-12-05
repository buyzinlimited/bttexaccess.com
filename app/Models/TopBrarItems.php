<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopBrarItems extends Model
{
    use HasFactory;

    protected $fillable = ['icon', 'text', 'sorting'];
}
