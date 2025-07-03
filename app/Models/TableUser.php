<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User;
use Illuminate\Notifications\Notifiable;

class TableUser extends User
{
    use Notifiable;

    protected $guarded = [];
    protected $primaryKey = 'id_user';

    public function getAuthIdentifierName(){
        return 'username';
    }

    public function getAuthPassword(){
        return $this->password;
    }
}
