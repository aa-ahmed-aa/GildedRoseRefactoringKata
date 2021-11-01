<?php

declare(strict_types=1);

namespace GildedRose;

use GildedRose\ItemTypes\AbstractItem;
use GildedRose\ItemTypes\AgedBrie;
use GildedRose\ItemTypes\Backstage;
use GildedRose\ItemTypes\Conjured;
use GildedRose\ItemTypes\Normal;
use GildedRose\ItemTypes\Sulfuras;

final class GildedRose
{
    /**
     * @var array
     */
    public static $types = [
        'Aged Brie' => AgedBrie::class,
        'Sulfuras, Hand of Ragnaros' => Sulfuras::class,
        'Backstage passes to a TAFKAL80ETC concert' => Backstage::class,
        'Conjured Mana Cake' => Conjured::class,
    ];

    /**
     * @var AbstractItem[]
     */
    private $items;

    public function __construct(array $items)
    {
        $this->items = $items;
    }

    /**
     * @param AbstractItem $item
     * @return Normal
     */
    public static function createType($item)
    {
        if (array_key_exists($item->name, self::$types)) {
            return new self::$types[$item->name]($item->name, $item->sell_in, $item->quality);
        }

        return new Normal($item->name, $item->sell_in, $item->quality);
    }

    public function updateQuality(): array
    {
        foreach ($this->items as $key => $item) {
            $this->items[$key] = self::createType($item);
            $this->items[$key]->updateQuality();
        }
        return $this->items;
    }
}
