<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MarginPenjualan extends Model
{
    protected $table = 'margin_penjualan';
    protected $primaryKey = 'idmargin_penjualan';
    public $timestamps = false;   // created_at & updated_at diisi otomatis oleh MySQL
    protected $fillable = ['persen', 'status', 'iduser'];

    public function user() {
        return $this->belongsTo(Pengguna::class, 'iduser', 'iduser');
    }
}
