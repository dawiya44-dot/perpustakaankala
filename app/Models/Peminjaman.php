<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjaman';
    protected $primaryKey = 'id_pinjam';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $guarded = [];

    public function anggota()
    {
        return $this->belongsTo(Anggota::class, 'id_anggota', 'id_anggota');
    }

    public function detailBuku()
    {
        return $this->belongsTo(DetailBuku::class, 'no_buku', 'no_buku');
    }
}
