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

        abstract class Handler {

            protected $successor;
            //protected $item;

            /*
            public function __constructor($item){
                $this->item=$item;
            }
            */

            public function setNext($handler){
               $this->successor=$handler;
            }

            public function updateItem ($item)
            {
                if ($this->successor != null)
                {
                    $this->successor->updateItem();
                }
                //Поведение по умолчанию
                else{
                    $item->sell_in = $item->sell_in - 1;
                    $item->quality = $item->quality - 1;
                }
            }

        }

        

        class conjuredItemHandler extends Handler {

            private $name='Conjured';

            public function updateItem (){
                if($this->item->name==$this->name){
                    $this->item->sell_in = $this->item->sell_in - 1;
                    $this->item->quality = $this->item->quality - 2;
                }
                else{
                    parent::updateItem ();
                }
            }

        }

        class sulfurasItemHandler extends Handler {

            private $name='Sulfuras, Hand of Ragnaros';

            public function updateItem (){
                if($this->item->name==$this->name){
                    $this->item->sell_in = $this->item->sell_in;
                    $this->item->quality = $this->item->quality;
                }
                else{
                    parent::updateItem ();
                }
            }

        }

        class agedBrieItemHandler extends Handler {

            private $name='Aged Brie';

            public function updateItem (){
                if($this->item->name==$this->name){
                    $this->item->sell_in = $this->item->sell_in-1;
                    $this->item->quality = $this->item->quality+1;
                }
                else{
                    parent::updateItem ();
                }
            }
        }

        class backstagePassesItemHandler extends Handler {

            private $name='Backstage passes to a TAFKAL80ETC concert';

            public function updateItem (){
                if($this->item->name==$this->name){

                    if ($this->item->sell_in>11){
                        $this->item->sell_in = $this->item->sell_in-1;
                        $this->item->quality = $this->item->quality+1;
                    }
                    elseif ($this->item->sell_in>6){
                        $this->item->sell_in = $this->item->sell_in-1;
                        $this->item->quality = $this->item->quality+2;
                    }
                    elseif ($this->item->sell_in>0){
                        $this->item->sell_in = $this->item->sell_in-1;
                        $this->item->quality = $this->item->quality+3;
                    
                    }
                    elseif ($this->item->sell_in==0){
                        $this->item->quality = 0;
                    }
                }
                else{
                    parent::updateItem ();
                }
            }
        }

        foreach ($this->items as $item) {
            $conjured=new conjuredItemHandler($item);
            $sulfuras=new sulfurasItemHandler($item);
            $agedBrie=new agedBrieItemHandler($item);
            $backstagePasses=new backstagePassesItemHandler($item);

            $conjured->setNext($sulfuras);
            $sulfuras->setNext($agedBrie);
            $agedBrie->setNext($backstagePasses);
            $conjured->updateItem ();


        }


    

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
    }
}
