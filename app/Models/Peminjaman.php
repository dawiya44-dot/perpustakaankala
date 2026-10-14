<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model Peminjaman
 *
 * Merepresentasikan transaksi peminjaman buku oleh anggota.
 *
 * @property string      $id_pinjam
 * @property string      $id_anggota
 * @property string      $no_buku
 * @property string      $tgl_pinjam
 * @property string      $tgl_kembali
 * @property string|null $tgl_dikembalikan
 * @property string      $status  '1' = dipinjam, '0' = selesai
 * @property int         $denda
 */
class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjaman';
    protected $primaryKey = 'id_pinjam';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $guarded = [];

    /**
     * Relasi ke data anggota yang meminjam.
     */
    public function anggota()
    {
        return $this->belongsTo(Anggota::class, 'id_anggota', 'id_anggota');
    }

    /**
     * Relasi ke eksemplar fisik buku yang dipinjam.
     */
    public function detailBuku()
    {
        return $this->belongsTo(DetailBuku::class, 'no_buku', 'no_buku');
    }
}
