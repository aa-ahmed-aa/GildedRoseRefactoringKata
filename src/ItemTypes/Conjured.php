<?php

namespace GildedRose\ItemTypes;

class Conjured extends AbstractItem
{
    public function updateQuality(): void
    {
        --$this->sell_in;
        $this->quality -= 2;

        if ($this->sell_in <= 0) {
            $this->quality -= 2;
        }

        parent::updateQuality();
    }
}
