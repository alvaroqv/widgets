<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JsonFiles extends Model
{
    protected $fillable = ['name', 'filename', 'status', 'lastline'];
}
