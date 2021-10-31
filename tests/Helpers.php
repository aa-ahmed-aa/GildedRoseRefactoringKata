<?php


namespace Tests;


trait Helpers
{
    public function assetForIndex($index, $name, $sell_in, $quality)
    {
        $this->assertSame($name, $this->items[$index]->name);
        $this->assertSame($sell_in, $this->items[$index]->sell_in);
        $this->assertSame($quality, $this->items[$index]->quality);
    }
}
