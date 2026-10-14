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
     * Cast tipe data kolom secara otomatis.
     */
    protected $casts = [
        'tgl_pinjam'       => 'datetime',
        'tgl_kembali'      => 'datetime',
        'tgl_dikembalikan' => 'datetime',
        'denda'            => 'integer',
    ];

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

    /**
     * Mengecek apakah peminjaman ini sudah melewati tenggat waktu pengembalian.
     */
    public function isLate(): bool
    {
        return $this->status === '1' && \Carbon\Carbon::now()->greaterThan($this->tgl_kembali);
    }

    /**
     * Menghitung estimasi denda keterlambatan dalam rupiah (Rp 1.000/hari).
     */
    public function hitungDenda(): int
    {
        if (!$this->isLate()) {
            return 0;
        }

        $today        = \Carbon\Carbon::today();
        $dueDateStart = \Carbon\Carbon::parse($this->tgl_kembali)->startOfDay();
        $daysLate     = max(0, (int) $dueDateStart->diffInDays($today));

        return $daysLate * 1000;
    }
}
