<?php

namespace App\Models;

use App\Features\HubFeatures;
use Illuminate\Database\Eloquent\Model;

class Hub extends Model
{
    use HubFeatures;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function matches()
    {
        return $this->morphMany(Match::class, 'subject');
    }
}
