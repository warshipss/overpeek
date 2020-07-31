<?php

namespace App\Console\Commands;

use App\Connections\DMarket;
use App\Models\Item;
use Carbon\Carbon;
use Illuminate\Console\Command;

class DMarketParse extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dmarket:parse';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $dmarket = new DMarket;

        $items = $dmarket->getItems();

        foreach ($items->objects as $item)
        {
            $record = Item::firstOrNew([
                'uid' => $item->itemId,
            ]);

            $record->fill([
                'game' => $item->gameId,
                'title' => $item->title,
                'image' => $item->image,
                'rarity' => $item->extra->quality,
                'price' => (int) $item->price->USD,
                'float' => (float) $item->extra->floatValue,
                'steam_price' => (int) $item->suggestedPrice->USD,
                'locked_to' => Carbon::now()->addSecond($item->extra->tradeLockDuration),
            ]);

            $record->save();
        }
    }
}
