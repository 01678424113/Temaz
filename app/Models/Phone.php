<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{
    //
    public static $FAIL = -1;
    public static $NOT_PROCESS = 0;
    public static $PROCESS = 1;
    public static $SUCCESS = 2;
}
