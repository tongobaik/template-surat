<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Siswa extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama',
        'nisn',
        'nik',
        'tempat_lahir',
        'tanggal_lahir',
        'is_active',
        'jenis_kelamin',
        'nama_ayah',
        'nama_ibu',
        'kelas_tahun_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'tanggal_lahir' => 'date',
        'is_active' => 'boolean',
        'kelas_tahun_id' => 'integer',
    ];

    public function kelasTahun(): BelongsTo
    {
        return $this->belongsTo(KelasTahun::class);
    }
}
