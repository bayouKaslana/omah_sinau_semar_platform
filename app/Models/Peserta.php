<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peserta extends Model
{
    protected $table = 'peserta';

    protected $fillable = [
        'no_peserta', 'nama', 'asal_sekolah',
        'mapel', 'tingkat', 'kelas', 'ruang', 'is_published',
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];

    public function getTingkatLabelAttribute(): string
    {
        return strtoupper($this->tingkat);
    }

    public function getMapelIconAttribute(): string
    {
        return match (strtolower($this->mapel)) {
            'matematika'    => '🔢',
            'bahasa inggris','b.inggris' => '🌍',
            'sains'         => '🔬',
            'ips'           => '🗺️',
            'mewarnai'      => '🎨',
            default         => '📚',
        };
    }
}
