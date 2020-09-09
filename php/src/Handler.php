<?php

namespace GildedRose;

//Шаблон цепочка обязанностей
abstract class Handler
{

	//Следующий элемент в цепочке обработчиков
	protected $successor;
	//Имя товара
	protected $name;
	//Скорость уменьшения или увеличения качества
	protected $speed;

	//Проверка границ качества товара
	public function checkLimit($item)
	{
		if ($item->quality < 0) {
			$item->quality = 0;
		}
	}

	//Определение скорости уменьшения или увеличения качества
	public function setSpeed($item)
	{
		if ($item->sell_in <= 0) {
			$this->speed = 2;
		} else {
			$this->speed = 1;
		}
	}

	//Задание следующего обработчика в цепочке
	public function setNext($handler)
	{
		$this->successor = $handler;
	}

	//Метод изменения качества и срока годности товара
	public function updateItem($item)
	{
		//Если обработчик не смог обработать товар, вызывается метод следующего обработчика
		if ($this->successor != null) {
			$this->successor->updateItem($item);
		}
	}
}

//Обработчик для товара 'Conjured'
class conjuredItemHandler extends Handler
{

	protected $name = 'Conjured Mana Cake';

	public function checkLimit($item)
	{
		//Метод из родительского класса не меняется
		parent::checkLimit($item);
	}

	public function setSpeed($item)
	{
		parent::setSpeed($item);
	}

	public function updateItem($item)
	{
		//Если имя товара 'Conjured'
		if ($item->name == $this->name) {
			//Задание скорости изменения качества
			$this->setSpeed($item);
			//Изменение срока годности и качества
			$item->sell_in = $item->sell_in - 1;
			$item->quality = $item->quality - 2 * $this->speed;
			//Проверка, достиго ли качество порогового значения
			$this->checkLimit($item);
		} else {
			//Иначе вызываем следующий обработчик
			parent::updateItem($item);
		}
	}
}

//Обработчик для товара 'Sulfuras'
class sulfurasItemHandler extends Handler
{

	protected $name = 'Sulfuras, Hand of Ragnaros';

	public function updateItem($item)
	{
		//Если имя товара 'Sulfuras'
		if ($item->name == $this->name) {
			//Качество и срок годности не меняются
			$item->sell_in = $item->sell_in;
			$item->quality = $item->quality;
		} else {
			//Иначе вызываем следующий обработчик
			parent::updateItem($item);
		}
	}
}

//Обработчик для товара 'Aged Brie'
class agedBrieItemHandler extends Handler
{

	protected $name = 'Aged Brie';

	//Изменение проверки границы качества товара
	public function checkLimit($item)
	{
		if ($item->quality > 50) {
			$item->quality = 50;
		}
	}

	public function setSpeed($item)
	{
		parent::setSpeed($item);
	}

	public function updateItem($item)
	{
		//Если имя товара 'Aged Brie'
		if ($item->name == $this->name) {
			$this->setSpeed($item);
			//Изменение срока годности и качества в сторону увеличения
			$item->sell_in = $item->sell_in - 1;
			$item->quality = $item->quality + 1 * $this->speed;
			$this->checkLimit($item);
		} else {
			//Иначе вызываем следующий обработчик
			parent::updateItem($item);
		}
	}
}

//Обработчик для товара 'Backstage'
class backstagePassesItemHandler extends Handler
{

	protected $name = 'Backstage passes to a TAFKAL80ETC concert';

	//Изменение проверки границы качества товара
	public function checkLimit($item)
	{
		if ($item->quality > 50) {
			$item->quality = 50;
		}
	}

	//Выбор скорости изменения качества в зависимости от срока годности 
	public function setSpeed($item)
	{
		if ($item->sell_in > 10) {
			$this->speed = 1;
		} elseif ($item->sell_in > 5) {
			$this->speed = 2;
		} elseif ($item->sell_in > 0) {
			$this->speed = 3;
		} elseif ($item->sell_in <= 0) {
			$this->speed = 0;
			$item->quality = 0;
		}
	}

	public function updateItem($item)
	{
		//Если имя товара 'Backstage'
		if ($item->name == $this->name) {
			$this->setSpeed($item);
			//Изменение срока годности и качества в сторону увеличения
			$item->sell_in = $item->sell_in - 1;
			$item->quality = $item->quality + 1 * $this->speed;
			//Иначе вызываем следующий обработчик
			$this->checkLimit($item);
		} else {
			parent::updateItem($item);
		}
	}
}

//Обработчик для обычных товаров
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
		$this->setSpeed($item);
		$item->sell_in = $item->sell_in - 1;
		$item->quality = $item->quality - 1 * $this->speed;
		$this->checkLimit($item);
	}
}
