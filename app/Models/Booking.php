<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nama_pemesan',
        'jenis_lapangan',
        'tanggal_booking',
        'jam_mulai',
        'jam_selesai',
        'kontak',
        'status',
        'user_id',
    ];

    protected $dates = ['deleted_at'];

    /**
     * Mendapatkan user yang membuat booking
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
