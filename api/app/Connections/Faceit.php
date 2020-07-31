<?php

namespace App\Connections;

use Carbon\Carbon;
use GuzzleHttp\Client;

class Faceit extends AbstractServiceConnection
{
    /**
     * @return array
     */
    public function getHttpClientConfig()
    {
        $apiUrl = 'https://open.faceit.com/data/v4/';

        $headers = [
            'Authorization' => 'Bearer ' . $this->config->key,
        ];

        if (isset($this->config->use_private_api) && $this->config->use_private_api === true)
        {
            $apiUrl = 'https://api.faceit.com/';
            $headers['userId'] = $this->config->user_id;
        }

        return [
            'base_uri' => $apiUrl,
            'headers' => $headers,
        ];
    }

    /**
     * @param $matchId
     *
     * @return object
     */
    public function cancelMatch($matchId)
    {
        return $this->request('POST', "match/v1/match-actions/{$matchId}/state", [
            'state' => 'CANCELLED',
        ]);
    }

    /**
     * @param $queue
     * @param $user
     * @param $reason
     * @param $minutes
     * @return object
     */
    public function banFromQueue($queue, $user, $reason, $minutes)
    {
        return $this->request('POST', 'queue/v1/ban', [
            'queueId' => $queue,
            'userId' => $user,
            'reason' => $reason,
            'banStart' => Carbon::now()->timestamp * 1e3,
            'banEnd' => Carbon::now()->addMinutes($minutes)->timestamp * 1e3,
        ]);
    }

    /**
     * @param $hubId
     * @param $userId
     * @param $reason
     * @return object
     */
    public function banFromHub($hubId, $userId, $reason)
    {
        return $this->request('POST', "hubs/v1/hub/{$hubId}/ban/{$userId}", [
            'hubId' => $hubId,
            'userId' => $userId,
            'reason' => $reason,
        ]);
    }

    /**
     * @param $match_id
     *
     * @return object
     */
    public function getMatch($match_id)
    {
        return $this->request('GET', 'matches/' . $match_id);
    }

    /**
     * @param $match_id
     *
     * @return object
     */
    public function getMatchStats($match_id)
    {
        return $this->request('GET', "matches/{$match_id}/stats");
    }
}
