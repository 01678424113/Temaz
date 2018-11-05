<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SmsData extends Model
{
    protected $table = 'sms_datas';
    public static $ACTIVE = 1;
    public static $UNACTIVE = 0;
}
