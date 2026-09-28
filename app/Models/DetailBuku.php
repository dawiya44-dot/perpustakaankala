<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailBuku extends Model
{
    use HasFactory;

    protected $table = 'detail_buku';
    protected $primaryKey = 'no_buku';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $guarded = [];

    public function buku()
    {
        return $this->belongsTo(Buku::class, 'id_buku', 'id_buku');
    }
}
