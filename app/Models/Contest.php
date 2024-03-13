<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Contest extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'description', 'winner_prize', 'runner_up_prize'];

    public function contestDetails(): HasMany
    {
        return $this->hasMany(ContestDetails::class);
    }

    public function winners()
    {
        return $this->hasMany(Winner::class);
    }
}
