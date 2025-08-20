<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Opd extends Model
{
    protected $fillable = ['name', 'kode'];

    /**
     * Get the users associated with the OPD.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get the SOPs associated with the OPD.
     */
    public function sops()
    {
        return $this->hasMany(Sop::class);
    }
}
