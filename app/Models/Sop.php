<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sop extends Model
{
     use HasFactory;

    protected $fillable = [
        'judul',
        'slug',
        'file',
        'user_id',
        'deskripsi',
        'status',
        'feedback',
        'signed_at',
        'opd_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function opd()
    {
        return $this->belongsTo(Opd::class);
    }
}
