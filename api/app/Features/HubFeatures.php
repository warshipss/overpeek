<?php

namespace App\Features;

trait HubFeatures
{
    /**
     * @param $uid
     * @param Roster $roster
     *
     * @return mixed
     */
    public function createMatch($uid, Roster $roster)
    {
        $match = $this->matches()->create([
            'uid' => $uid,
        ]);

        $match->players()->sync($roster->asRelation());

        return $match;
    }
}
