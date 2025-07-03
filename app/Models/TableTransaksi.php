<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TableTransaksi extends Model
{
    protected $guarded=[];
    protected $primaryKey='id_transaksi';
    public function user()
    {
        return $this->belongsTo(\App\Models\TableUser::class, 'id_user');
    }
}
