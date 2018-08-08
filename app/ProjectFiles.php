<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectFiles extends Model
{
    protected $fillable = ['name', 'filename', 'status', 'lastline'];
}
