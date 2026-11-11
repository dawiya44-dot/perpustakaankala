<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use App\Models\Anggota;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::created(function (User $user) {
            // Jangan buat anggota duplikat jika nama sudah ada
            if (!Anggota::where('nama_anggota', $user->name)->exists()) {
                $maxNum = Anggota::all()->map(function ($a) {
                    return (int) preg_replace('/[^0-9]/', '', $a->id_anggota);
                })->max() ?? 0;

                $nextId = 'a' . str_pad($maxNum + 1, 4, '0', STR_PAD_LEFT);

                Anggota::create([
                    'id_anggota'   => $nextId,
                    'nama_anggota' => substr($user->name, 0, 50),
                    // kelas, tempatlahir, tgllahir dibiarkan null agar admin
                    // dapat melengkapinya melalui form Edit Data Anggota
                    'kelas'        => null,
                    'tempatlahir'  => null,
                    'tgllahir'     => null,
                    'no_wa'        => null,
                ]);
            }
        });
    }
}
