<?php

namespace GildedRose;

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

	private $name = 'Conjured Mana Cake';

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