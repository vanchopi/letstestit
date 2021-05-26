<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Info extends Model
{
    //
    protected $fillable = ['name', 'email', 'message'];
    protected $table = 'info';
}
