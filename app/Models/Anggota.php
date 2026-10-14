<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model Anggota
 *
 * Merepresentasikan data anggota perpustakaan.
 *
 * @property string $id_anggota
 * @property string $nama_anggota
 * @property string $kelas
 * @property string|null $no_wa
 * @property string|null $tempatlahir
 * @property string|null $tgllahir
 */
class Anggota extends Model
{
    use HasFactory;

    protected $table = 'anggota';
    protected $primaryKey = 'id_anggota';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $guarded = [];

    /**
     * Cast tipe data kolom secara otomatis.
     */
    protected $casts = [
        'tgllahir' => 'date',
    ];

    /**
     * Relasi ke data peminjaman anggota.
     */
    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'id_anggota', 'id_anggota');
    }
}
