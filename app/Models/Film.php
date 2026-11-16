<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Film extends Model
{
    protected $fillable = ['cim', 'szines', 'szinkron', 'szarmazas', 'mufaj', 'hossz'];

    protected function casts(): array
    {
        return [
            'szines' => 'boolean',
            'hossz' => 'integer',
        ];
    }

    public function mozik(): BelongsToMany
    {
        return $this->belongsToMany(Mozi::class, 'film_mozi');
    }
}
