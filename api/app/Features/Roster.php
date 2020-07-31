<?php

namespace App\Features;

use App\Models\User;
use Illuminate\Support\Collection;

class Roster
{
    /**
     * @var Collection
     */
    protected $roster = null;

    /**
     * @var array
     */
    protected $related = null;

    /**
     * @var Collection
     */
    protected $users = null;

    /**
     * Roster constructor.
     *
     * @param $teams
     */
    public function __construct($teams)
    {
        $roster = collect();

        foreach ($teams as $team)
        {
            foreach ($team->roster as $player)
            {
                $roster->put($player->id, [
                    'team' => $team->id
                ]);
            }
        }

        $this->roster = $roster;
    }

    /**
     * @return Collection
     */
    public function users()
    {
        if ($this->users !== null) {
            return $this->users;
        }

        $this->users = User::select('id', 'uid', 'gold')
            ->whereIn('uid', $this->ids())
            ->get()
            ->keyBy('uid');

        return $this->users;
    }

    /**
     * @return Collection
     */
    public function unregistered()
    {
        $users = $this->users();

        return $this->roster->filter(function ($value, $key) use ($users) {
            return $users->get($key) === null;
        });
    }

    /**
     * @return Collection
     */
    public function register()
    {
        $bulk = $this->unregistered()->keys()->map(function ($key) {
            return [
                'uid' => $key,
                'nickname' => 'Unregistered',
            ];
        });

        return \DB::table('users')->insert($bulk->all());
    }

    /**
     * @param int $amount
     *
     * @return bool
     */
    public function hasMoney($amount = 0)
    {
        return $this->roster->count() === $this->users()->where('gold', '>=', $amount)->count();
    }

    /**
     * @param int $amount
     *
     * @return bool
     */
    public function payFee($amount)
    {
        return User::whereIn('uid', $this->ids())
            ->decrement('gold', $amount);
    }

    /**
     * @return array
     */
    public function asRelation()
    {
        $users = $this->users();

        return $this->roster
            ->mapWithKeys(function ($value, $key) use ($users) {
                return [$users->get($key)->id => $value];
            })
            ->all();
    }

    /**
     * @return array
     */
    public function ids()
    {
        return $this->roster->keys()->all();
    }

    /**
     * @return array
     */
    public function all()
    {
        return $this->roster->all();
    }
}
