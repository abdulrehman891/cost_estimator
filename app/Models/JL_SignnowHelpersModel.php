<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JL_SignnowHelpersModel extends Model
{
    use HasFactory;
    protected $fillable = [
        'id', 'data','expires_in'
    ];
    protected $table = 'signnow_tokens';
}
