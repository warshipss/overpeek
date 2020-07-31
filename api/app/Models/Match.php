<?php

namespace App\Models;

use App\Features\MatchFeatures;
use Illuminate\Database\Eloquent\Model;

class Match extends Model
{
    use MatchFeatures;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function players()
    {
        return $this->belongsToMany(User::class, 'match_player')->withPivot('team');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function subject()
    {
        return $this->morphTo();
    }
}
