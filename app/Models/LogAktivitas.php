<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogAktivitas extends Model
{
    use HasFactory;

    protected $table = 'log_aktivitas';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'aktivitas',
        'waktu',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public static function catat($aktivitas)
    {
        if (!auth()->check()) {
            return;
        }

        self::create([
            'user_id'   => auth()->id(),
            'aktivitas' => $aktivitas,
            'waktu'     => now(),
        ]);
    }
}