<?php

namespace IMEI\Models;

use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{
    protected $table = 'table_imeis';

    protected $guarded = ['id'];
}
