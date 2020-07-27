<?php

namespace App\Packages\IMEI\Models;

use Illuminate\Database\Eloquent\Model;

class Imei extends Model
{
    protected $table = 'imeis';

    protected $guarded = ['id'];
}
