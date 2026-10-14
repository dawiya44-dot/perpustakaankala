<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model Buku
 *
 * Merepresentasikan data buku koleksi perpustakaan.
 *
 * @property string $id_buku
 * @property string $judul_buku
 * @property string $pengarang
 * @property string $penerbit
 * @property int    $tahun_terbit
 * @property int    $jumlah
 */
class Buku extends Model
{
    use HasFactory;

    protected $table = 'buku';
    protected $primaryKey = 'id_buku';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $guarded = [];

    /**
     * Relasi ke eksemplar fisik buku di tabel detail_buku.
     */
    public function detailBuku()
    {
        return $this->hasMany(DetailBuku::class, 'id_buku', 'id_buku');
    }
}
