<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use Notifiable, HasRoles;

    public static $ACTIVE_STATUS = 1;

    protected static function getAllData()
    {
        return Admin::cursor();
    }

    protected $fillable = [
        'name', 'email', 'password', 'status', 'amount', 'created_at', 'updated_at', 'role',
    ];
}
