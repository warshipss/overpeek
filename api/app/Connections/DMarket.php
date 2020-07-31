<?php

namespace App\Connections;

class DMarket extends AbstractServiceConnection
{
    /**
     * @return array
     */
    public function getHttpClientConfig()
    {
        return [
            'base_uri' => 'https://api.dmarket.com/exchange/v1/market/',
        ];
    }

    /**
     * @param int $offset
     * @param int $limit
     *
     * @return object
     */
    public function getItems($offset = 0, $limit = 100)
    {
        return $this->request('GET', 'items', [
            'title' => '',
            'priceTo' => '0',
            'limit' => $limit,
            'priceFrom' => '0',
            'gameId' => 'a8db',
            'offset' => $offset,
            'treeFilters' => '',
            'currency' => 'USD',
            'orderDir' => 'desc',
            'orderBy' => 'best_deals',
        ]);
    }
}
