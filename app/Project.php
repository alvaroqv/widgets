<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = ['id','name', 'filename', 'status', 'lastline'];
}