<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{
    //
    protected static $BOUGHT = 1;
    protected static $UNBOUGHT = 1;
    protected $fillable = ['phone', 'category_id', 'ip', 'address', 'link', 'time', 'status', 'created_at', 'updated_at'];
}
