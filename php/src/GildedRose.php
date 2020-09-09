<?php

declare(strict_types=1);



namespace GildedRose;

//Подключение классов обработчиков
require_once __DIR__ . '/Handler.php';

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
        foreach ($this->items as $item) {

            //Создание объектов обработчиков
            $conjured = new conjuredItemHandler();
            $sulfuras = new sulfurasItemHandler();
            $agedBrie = new agedBrieItemHandler();
            $backstagePasses = new backstagePassesItemHandler();
            $normal = new normalItemHandler();

            //Создание цепочки обработчиков
            $conjured->setNext($sulfuras);
            $sulfuras->setNext($agedBrie);
            $agedBrie->setNext($backstagePasses);
            $backstagePasses->setNext($normal);

            //Обработка товара
            $conjured->updateItem($item);
        }
    }
}
