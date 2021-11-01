<?php

namespace Tests;

trait Helpers
{
    public function assetForIndex(int $index, string $name, int $sell_in, int $quality): void
    {
        $this->assertSame($name, $this->items[$index]->name);
        $this->assertSame($sell_in, $this->items[$index]->sell_in);
        $this->assertSame($quality, $this->items[$index]->quality);
    }
}
