<?php

namespace GildedRose\ItemTypes;

class Normal extends AbstractItem
{
    public function updateQuality(): void
    {
        --$this->sell_in;
        --$this->quality;

        if ($this->sell_in <= 0) {
            $this->quality -= 2;
        }

        parent::updateQuality();
    }
}
