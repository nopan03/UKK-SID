<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogAktivitas extends Model
{
    protected $table = 'log_aktivitas';
    protected $guarded = ['id'];

    // Relasi ke User (Siapa yang melakukan aktivitas)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}