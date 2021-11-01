<?php

namespace GildedRose\ItemTypes;

class AgedBrie extends AbstractItem
{
    public function updateQuality(): void
    {
        parent::updateQuality();

        if ($this->sell_in <= 0) {
            $this->quality += 2;
            --$this->sell_in;
        } else {
            --$this->sell_in;
            ++$this->quality;
        }
    }
}
