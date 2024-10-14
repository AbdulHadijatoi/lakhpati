<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Contest extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'description', 'winner_prize', 'runner_up_prize','status'];

    protected $with = ['contestDetails'];

    protected $appends = ['total_participants'];

    public function contestDetails(): HasOne
    {
        return $this->hasOne(ContestDetails::class,'contest_id');
    }

    public function winners()
    {
        return $this->hasMany(Winner::class);
    }
    
    public function participants()
    {
        return $this->hasMany(Participant::class,'contest_id');
    }

    // Accessor for total number of participants
    public function getTotalParticipantsAttribute(): int
    {
        return $this->participants()->count();
    }
}
