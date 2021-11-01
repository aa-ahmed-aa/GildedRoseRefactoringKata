<?php

namespace GildedRose\ItemTypes;

abstract class AbstractItem implements AbstractItemInterface
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var int
     */
    public $sell_in;

    /**
     * @var int
     */
    public $quality;

    public function __construct(string $name, int $sell_in, int $quality)
    {
        $this->name = $name;
        $this->sell_in = $sell_in;
        $this->quality = $quality;
    }

    public function updateQuality(): void
    {
        if ($this->quality >= 50) {
            $this->quality = 50;
        }

        if ($this->quality <= 0) {
            $this->quality = 0;
        }
    }
}
