<?php

namespace App\Features;

use App\Models\Match;
use App\Connections\Faceit;

trait MatchFeatures
{
    /**
     * Cancel the match.
     *
     * @param string $reason
     * @param bool $returnBets
     *
     * @return string
     */
    public function cancel($reason = '', $returnBets = true)
    {
        $this->state = 'canceled';
        $this->cancel_reason = $reason;
        $this->save();

        app('faceit.private')
            ->cancelMatch($this->uid);

        if ($returnBets && $this->subject_type === 'hub')
        {
            $this->players()
                ->increment('gold', $this->subject->bet);
        }

        return 'OK';

        // TODO: Bans
        // $faceit->banFromQueue('5e7f736c1a57de0006afca92', '7fbecf2b-2be0-4865-a84b-319414b5d415', 'No gold to play', 20);
    }

    /**
     * @param $winner_id
     */
    public function finish($winner_id)
    {
        \DB::beginTransaction();
        $this->state = 'finished';
        $this->winner_uid = $winner_id;
        $this->save();

        if ($this->subject_type === 'hub')
        {
            $this->players()
                ->wherePivot('team', $winner_id)
                ->increment('gold', $this->subject->bet * 1.9);
        }
        \DB::commit();
    }
}
