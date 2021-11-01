<?php

namespace GildedRose\ItemTypes;

class Backstage extends AbstractItem
{
    public function updateQuality(): void
    {
        if ($this->sell_in <= 5) {
            $this->quality += 3;
        } elseif ($this->sell_in <= 10) {
            $this->quality += 2;
        } else {
            ++$this->quality;
        }

        --$this->sell_in;

        //normal item
        parent::updateQuality();
    }
}
