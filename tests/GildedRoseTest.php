<?php

declare(strict_types=1);

namespace Tests;

use GildedRose\GildedRose;
use GildedRose\Item;
use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertEquals;

class GildedRoseTest extends TestCase
{
    use Helpers;

    /** @var array<Item> */
    public $items;

    protected function setUp(): void
    {
        parent::setUp();

        $this->items = [
            new Item("+5 Dexterity Vest", 10, 20),
            new Item("Aged Brie", 2, 0),
            new Item("Elixir of the Mongoose", 5, 7),
            new Item("Sulfuras, Hand of Ragnaros", 0, 80),
            new Item("Sulfuras, Hand of Ragnaros", -1, 80),
            new Item("Backstage passes to a TAFKAL80ETC concert", 15, 20),
            new Item("Backstage passes to a TAFKAL80ETC concert", 10, 49),
            new Item("Backstage passes to a TAFKAL80ETC concert", 5, 49),
            // this conjured item does not work properly yet
            new Item("Conjured Mana Cake", 3, 6),
        ];
    }

    public function test_object_to_string()
    {
        $item = new Item("+5 Dexterity Vest", 10, 20);

        $this->assertSame("+5 Dexterity Vest, 10, 20", (string)$item);
    }

    public function test_normal_item_after_1_day()
    {
        $gildedRose = new GildedRose($this->items);

        $gildedRose->updateQuality();

        $this->assetForIndex(0, "+5 Dexterity Vest", 9, 19);
    }

    public function test_normal_item_after_30_day()
    {
        $gildedRose = new GildedRose($this->items);

        array_map(function () use ($gildedRose) {
            $gildedRose->updateQuality();
        }, range(1, 30));

        $this->assetForIndex(0, "+5 Dexterity Vest", -20, 0);
    }

    public function test_sulfuras_item_after_1_day()
    {
        $gildedRose = new GildedRose($this->items);

        $gildedRose->updateQuality();

        $this->assetForIndex(3, "Sulfuras, Hand of Ragnaros", 0, 80);
    }

    public function test_sulfuras_item_after_30_day()
    {
        $gildedRose = new GildedRose($this->items);

        array_map(function () use ($gildedRose) {
            $gildedRose->updateQuality();
        }, range(1, 30));

        $this->assetForIndex(3, "Sulfuras, Hand of Ragnaros", 0, 80);
    }

    public function test_aged_brie_item_after_1_day()
    {
        $gildedRose = new GildedRose($this->items);

        $gildedRose->updateQuality();

        $this->assetForIndex(1, "Aged Brie", 1, 1);
    }

    public function test_aged_brie_item_after_5_day()
    {
        $gildedRose = new GildedRose($this->items);

        array_map(function () use ($gildedRose) {
            $gildedRose->updateQuality();
        }, range(1, 5));

        $this->assetForIndex(1, "Aged Brie", -3, 8);
    }

    public function test_aged_brie_item_after_10_day()
    {
        $gildedRose = new GildedRose($this->items);

        array_map(function () use ($gildedRose) {
            $gildedRose->updateQuality();
        }, range(1, 10));

        $this->assetForIndex(1, "Aged Brie", -8, 18);
    }

    public function test_backstage_item_after_1_day()
    {
        $gildedRose = new GildedRose($this->items);

        $gildedRose->updateQuality();

        $this->assetForIndex(5, "Backstage passes to a TAFKAL80ETC concert", 14, 21);
    }

    public function test_backstage_item_after_6_day()
    {
        $gildedRose = new GildedRose($this->items);

        array_map(function () use ($gildedRose) {
            $gildedRose->updateQuality();
        }, range(1, 6));

        $this->assetForIndex(5, "Backstage passes to a TAFKAL80ETC concert", 9, 27);
    }

    public function test_backstage_item_after_11_day()
    {
        $gildedRose = new GildedRose($this->items);

        array_map(function () use ($gildedRose) {
            $gildedRose->updateQuality();
        }, range(1, 11));

        $this->assetForIndex(5, "Backstage passes to a TAFKAL80ETC concert", 4, 38);
    }

    public function test_backstage_item_between_10_and_5_after_1_day()
    {
        $gildedRose = new GildedRose($this->items);

        $gildedRose->updateQuality();

        $this->assetForIndex(6, "Backstage passes to a TAFKAL80ETC concert", 9, 50);
    }

//    public function test_conjured_item_after_1_day()
//    {
//        $gildedRose = new GildedRose($this->items);
//
//        $gildedRose->updateQuality();
//
//        $this->assetForIndex(8, "Backstage passes to a TAFKAL80ETC concert", 2, 4);
//    }
}
