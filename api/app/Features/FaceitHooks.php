<?php

namespace App\Features;

use App\Models\Hub;
use App\Models\User;
use App\Models\Match;

trait FaceitHooks
{
    use Hubs;

    /**
     * @param $uid
     * @param bool $throwIfNotFound
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    private function getMatch($uid, $throwIfNotFound = true)
    {
        $match = Match::with('players', 'subject')
            ->where('uid', is_string($uid) ? $uid : $uid->id)
            ->first();

        if (! $match && $throwIfNotFound) {
            abort(404);
        }

        return $match;
    }

    /**
     * @param $payload
     *
     * @return bool
     */
    public function matchStatusFinished($payload)
    {
        $record = $this->getMatch($payload);

        if (! $record || $record->state !== 'going') {
            return false;
        }

        $match = app('faceit')->getMatch($record->uid);

        $winner = $match->teams->{$match->results->winner}->faction_id;

        return $record->finish($winner);
    }

    /**
     * @param $payload
     *
     * @return bool|string
     */
    public function matchStatusCancelled($payload)
    {
        $match = Match::with('users', 'subject')
            ->where('uid', $payload->id)
            ->first();

        if (! $match || $match->state !== 'going') {
            return false;
        }

        $match->cancel($payload->reason);

        return 'OK';
    }

    /**
     * @param $payload
     *
     * @return mixed
     */
    public function matchObjectCreated($payload)
    {
        $hub = Hub::where('uid', $payload->entity->id)
            ->firstOrFail();

        $match = $hub->matches()
            ->where('uid', $payload->id)
            ->first();

        // Check if match is already created
        if ($match) {
            return 'OK';
        }

        // Create roster object
        $roster = new Roster($payload->teams);

        // Register all players at the db
        $register = $roster->register();

        // Create new match
        $match = $hub->createMatch($payload->id, $roster);

        // Determines if all roster has enough money to play
        $hasMoney = $roster->hasMoney($hub->bet);

        // Cancel match if theres not enough money
        if (! $hasMoney) {
            return $match->cancel('not_enough_bets', false);
        }

        // Otherwise decrement balances
        $roster->payFee($hub->bet);

        return 'OK';
    }
}
