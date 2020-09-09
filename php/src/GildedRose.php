<?php

declare(strict_types=1);

namespace GildedRose;

final class GildedRose
{
    /**
     * @var Item[]
     */
    private $items;

    public function __construct(array $items)
    {
        $this->items = $items;
    }

    public function updateQuality(): void
    {

        abstract class Handler
        {

            protected $successor;
            protected $name;
            protected $speed;
            protected $limit;


            public function checkLimit($item)
            {
                if ($item->quality == 0) {
                    $this->limit == true;
                } else {
                    $this->limit == false;
                }
            }

            public function setSpeed($item)
            {
                if ($item->sell_in < 0) {
                    $this->speed = 2;
                } else {
                    $this->speed = 1;
                }
            }

            public function setNext($handler)
            {
                $this->successor = $handler;
            }

            public function updateItem($item)
            {
                if ($this->successor != null) {
                    $this->successor->updateItem($item);
                }
            }
        }

        class conjuredItemHandler extends Handler
        {

            private $name = 'Conjured';

            public function checkLimit($item)
            {
                parent::checkLimit($item);
            }

            public function setSpeed($item)
            {
                parent::setSpeed($item);
            }

            public function updateItem($item)
            {
                if ($item->name == $this->name) {

                    $this->checkLimit($item);
                    if ($this->limit == true) {
                        $item->sell_in = $item->sell_in - 1;
                        $item->quality = $item->quality;
                    } else {
                        $this->setSpeed($item);
                        $item->sell_in = $item->sell_in - 1;
                        $item->quality = $item->quality - 2 * $this->speed;
                    }
                } else {
                    parent::updateItem($item);
                }
            }
        }

        class sulfurasItemHandler extends Handler
        {

            private $name = 'Sulfuras, Hand of Ragnaros';

            public function updateItem($item)
            {
                if ($item->name == $this->name) {
                    $item->sell_in = $item->sell_in;
                    $item->quality = $item->quality;
                } else {
                    parent::updateItem($item);
                }
            }
        }

        class agedBrieItemHandler extends Handler
        {

            private $name = 'Aged Brie';


            
            public function checkLimit($item)
            {
                if ($item->quality == 50) {
                    $this->limit == true;
                } else {
                    $this->limit == false;
                }
            }

            public function setSpeed($item)
            {
                parent::setSpeed($item);
            }

            public function updateItem($item)
            {
                if ($item->name == $this->name) {

                    $this->checkLimit($item);
                    if ($this->limit == true) {
                        $item->sell_in = $item->sell_in - 1;
                        $item->quality = $item->quality;
                    } else {
                        $this->setSpeed($item);
                        $item->sell_in = $item->sell_in - 1;
                        $item->quality = $item->quality + 1 * $this->speed;
                    }
                } else {
                    parent::updateItem($item);
                }
            }
        }

        class backstagePassesItemHandler extends Handler
        {

            private $name = 'Backstage passes to a TAFKAL80ETC concert';


            
            public function checkLimit($item)
            {
                if ($item->quality == 50) {
                    $this->limit == true;
                } else {
                    $this->limit == false;
                }
            }

            public function setSpeed($item)
            {
                if ($item->sell_in > 10) {
                    $this->speed = 1;
                } elseif ($item->sell_in > 5) {
                    $this->speed = 2;
                }
                elseif ($item->sell_in >= 0) {
                    $this->speed = 3;
                }
                elseif ($item->sell_in < 0){
                    $this->speed = 0;
                    $item->quality=0;
                }
            }

            public function updateItem($item)
            {
                if ($item->name == $this->name) {

                    $this->checkLimit($item);
                    if ($this->limit == true) {
                        $item->sell_in = $item->sell_in - 1;
                        $item->quality = $item->quality;
                    } else {
                        $this->setSpeed($item);
                        $item->sell_in = $item->sell_in - 1;
                        $item->quality = $item->quality + 1 * $this->speed;
                    }
                } else {
                    parent::updateItem($item);
                }
            }
        }

        class normalItemHandler extends Handler
        {

            public function checkLimit($item)
            {
                parent::checkLimit($item);
            }

            public function setSpeed($item)
            {
                parent::setSpeed($item);
            }

            public function updateItem($item)
            {
                if ($item->name == $this->name) {

                    $this->checkLimit($item);
                    if ($this->limit == true) {
                        $item->sell_in = $item->sell_in - 1;
                        $item->quality = $item->quality;
                    } else {
                        $this->setSpeed($item);
                        $item->sell_in = $item->sell_in - 1;
                        $item->quality = $item->quality - 1 * $this->speed;
                    }
                } else {
                    parent::updateItem($item);
                }
            }

        }

        foreach ($this->items as $item) {
            $conjured = new conjuredItemHandler();
            $sulfuras = new sulfurasItemHandler();
            $agedBrie = new agedBrieItemHandler();
            $backstagePasses = new backstagePassesItemHandler();
            $normal = new normalItemHandler();

            $conjured->setNext($sulfuras);
            $sulfuras->setNext($agedBrie);
            $agedBrie->setNext($backstagePasses);
            $backstagePasses->setNext($normal);

            $conjured->updateItem($item);
        }


        /*
        foreach ($this->items as $item) {
            if ($item->name != 'Aged Brie' and $item->name != 'Backstage passes to a TAFKAL80ETC concert') {
                if ($item->quality > 0) {
                    if ($item->name != 'Sulfuras, Hand of Ragnaros') {
                        $item->quality = $item->quality - 1;
                    }
                }
            } else {
                if ($item->quality < 50) {
                    $item->quality = $item->quality + 1;
                    if ($item->name == 'Backstage passes to a TAFKAL80ETC concert') {
                        if ($item->sell_in < 11) {
                            if ($item->quality < 50) {
                                $item->quality = $item->quality + 1;
                            }
                        }
                        if ($item->sell_in < 6) {
                            if ($item->quality < 50) {
                                $item->quality = $item->quality + 1;
                            }
                        }
                    }
                }
            }

            if ($item->name != 'Sulfuras, Hand of Ragnaros') {
                $item->sell_in = $item->sell_in - 1;
            }

            if ($item->sell_in < 0) {
                if ($item->name != 'Aged Brie') {
                    if ($item->name != 'Backstage passes to a TAFKAL80ETC concert') {
                        if ($item->quality > 0) {
                            if ($item->name != 'Sulfuras, Hand of Ragnaros') {
                                $item->quality = $item->quality - 1;
                            }
                        }
                    } else {
                        $item->quality = $item->quality - $item->quality;
                    }
                } else {
                    if ($item->quality < 50) {
                        $item->quality = $item->quality + 1;
                    }
                }
            }
        }
        */
    }
}
