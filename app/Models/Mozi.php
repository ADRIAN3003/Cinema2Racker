<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Mozi extends Model
{
    protected $table = 'mozik';

    protected $fillable = ['nev', 'iranyitoszam', 'cim', 'telefon'];

    public function films(): BelongsToMany
    {
        return $this->belongsToMany(Film::class, 'film_mozi');
    }
}
