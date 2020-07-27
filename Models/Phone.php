<?php

namespace IMEI\Models;

use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{
    protected $table = 'imeis';

    protected $guarded = ['id'];
}
