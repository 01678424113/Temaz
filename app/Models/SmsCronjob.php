<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SmsCronjob extends Model
{
    protected $table = 'sms_cronjobs';
    public static $ACTIVE = 1;
    public static $UNACTIVE = 0;
}
