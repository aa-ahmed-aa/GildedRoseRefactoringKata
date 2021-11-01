<?php

declare(strict_types=1);

namespace Tests;

use GildedRose\GildedRose;
use GildedRose\Item;
use PHPUnit\Framework\TestCase;

class GildedRoseTest extends TestCase
{
    use Helpers;

    /**
     * @var array<Item>
     */
    public $items;

    protected function setUp(): void
    {
        $this->items = [
            new Item('+5 Dexterity Vest', 10, 20),
            new Item('Aged Brie', 2, 0),
            new Item('Elixir of the Mongoose', 5, 7),
            new Item('Sulfuras, Hand of Ragnaros', 0, 80),
            new Item('Sulfuras, Hand of Ragnaros', -1, 80),
            new Item('Backstage passes to a TAFKAL80ETC concert', 15, 20),
            new Item('Backstage passes to a TAFKAL80ETC concert', 10, 49),
            new Item('Backstage passes to a TAFKAL80ETC concert', 5, 49),
            // this conjured item does not work properly yet
            new Item('Conjured Mana Cake', 3, 6),
        ];
    }

    public function testObjectToString(): void
    {
        $item = new Item('+5 Dexterity Vest', 10, 20);

        $this->assertSame('+5 Dexterity Vest, 10, 20', (string) $item);
    }

    public function testNormalItemAfter1Day(): void
    {
        $gildedRose = new GildedRose($this->items);

        $this->items = $gildedRose->updateQuality();

        $this->assetForIndex(0, '+5 Dexterity Vest', 9, 19);
    }

    public function testNormalItemAfter30Day(): void
    {
        $gildedRose = new GildedRose($this->items);

        array_map(function () use ($gildedRose) {
            $this->items = $gildedRose->updateQuality();
        }, range(1, 30));

        $this->assetForIndex(0, '+5 Dexterity Vest', -20, 0);
    }

    public function testSulfurasItemAfter1Day(): void
    {
        $gildedRose = new GildedRose($this->items);

        $this->items = $gildedRose->updateQuality();

        $this->assetForIndex(3, 'Sulfuras, Hand of Ragnaros', 0, 80);
    }

    public function testSulfurasItemAfter30Day(): void
    {
        $gildedRose = new GildedRose($this->items);

        array_map(function () use ($gildedRose) {
            $this->items = $gildedRose->updateQuality();
        }, range(1, 30));

        $this->assetForIndex(3, 'Sulfuras, Hand of Ragnaros', 0, 80);
    }

    public function testAgedBrieItemAfter1Day(): void
    {
        $gildedRose = new GildedRose($this->items);

        $this->items = $gildedRose->updateQuality();

        $this->assetForIndex(1, 'Aged Brie', 1, 1);
    }

    public function testAgedBrieItemAfter5Day(): void
    {
        $gildedRose = new GildedRose($this->items);

        array_map(function () use ($gildedRose) {
            $this->items = $gildedRose->updateQuality();
        }, range(1, 5));

        $this->assetForIndex(1, 'Aged Brie', -3, 8);
    }

    public function testAgedBrieItemAfter10Day(): void
    {
        $gildedRose = new GildedRose($this->items);

        array_map(function () use ($gildedRose) {
            $this->items = $gildedRose->updateQuality();
        }, range(1, 10));

        $this->assetForIndex(1, 'Aged Brie', -8, 18);
    }

    public function testBackstageItemAfter1Day(): void
    {
        $gildedRose = new GildedRose($this->items);

        $this->items = $gildedRose->updateQuality();

        $this->assetForIndex(5, 'Backstage passes to a TAFKAL80ETC concert', 14, 21);
    }

    public function testBackstageItemAfter6Day(): void
    {
        $gildedRose = new GildedRose($this->items);

        array_map(function () use ($gildedRose) {
            $this->items = $gildedRose->updateQuality();
        }, range(1, 6));

        $this->assetForIndex(5, 'Backstage passes to a TAFKAL80ETC concert', 9, 27);
    }

    public function testBackstageItemAfter11Day(): void
    {
        $gildedRose = new GildedRose($this->items);

        array_map(function () use ($gildedRose) {
            $this->items = $gildedRose->updateQuality();
        }, range(1, 11));

        $this->assetForIndex(5, 'Backstage passes to a TAFKAL80ETC concert', 4, 38);
    }

    public function testBackstageItemBetween10And5After1Day(): void
    {
        $gildedRose = new GildedRose($this->items);

        $this->items = $gildedRose->updateQuality();

        $this->assetForIndex(6, 'Backstage passes to a TAFKAL80ETC concert', 9, 50);
    }

    public function testConjuredItemAfter1Day(): void
    {
        $gildedRose = new GildedRose($this->items);

        $this->items = $gildedRose->updateQuality();

        $this->assetForIndex(8, 'Conjured Mana Cake', 2, 4);
    }
}
