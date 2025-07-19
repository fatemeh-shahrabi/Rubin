<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GlobalChat extends Model
{
    use HasFactory;

    protected $fillable = ['message', 'sender'];

}
