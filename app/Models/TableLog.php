<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TableLog extends Model
{
    protected $guarded=[];
    public function user()
    {
        return $this->belongsTo(TableUser::class, 'id_user');
    }
}
