<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Auth;

class Contest extends Model
{
    use HasFactory;
    
    protected $guarded = [];

    protected $with = ['contestDetails'];

    protected $appends = ['total_participants', 'has_active_participation'];

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

    // Accessor to check if the authenticated user has active participation in the contest
    public function getHasActiveParticipationAttribute(): bool
    {
        if (!Auth::check()) {
            // If the user is not authenticated, return false
            return false;
        }

        $userId = Auth::id(); // Get the authenticated user's ID

        return $this->participants()
            ->where('user_id', $userId)
            ->where('status', 1) // Assuming 'status' defines if participation is active
            ->exists();
    }
}
