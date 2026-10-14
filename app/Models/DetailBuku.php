<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model DetailBuku
 *
 * Merepresentasikan eksemplar fisik dari sebuah buku (satu buku bisa
 * memiliki banyak eksemplar fisik yang masing-masing bisa dipinjam secara terpisah).
 *
 * @property string $no_buku   Nomor fisik eksemplar, misal: b001_01
 * @property string $id_buku   FK ke tabel buku
 * @property string $status    'ada' atau 'dipinjam'
 */
class DetailBuku extends Model
{
    use HasFactory;

    protected $table = 'detail_buku';
    protected $primaryKey = 'no_buku';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $guarded = [];

    /**
     * Relasi ke data induk buku.
     */
    public function buku()
    {
        return $this->belongsTo(Buku::class, 'id_buku', 'id_buku');
    }

    /**
     * Relasi ke riwayat peminjaman eksemplar fisik ini.
     */
    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'no_buku', 'no_buku');
    }
}
