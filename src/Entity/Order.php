<?php

namespace Recruitment\Entity;

class Order
{
    private $id;
    private $items;
    private $totalPrice;
    private $totalPriceBrutto;

    /**
     * @return int
     */
    public function getId():int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Order
     */
    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return array
     */
    public function getItems():array
    {
        return $this->items;
    }

    /**
     * @param array $items
     * @return Order
     */
    public function setItems(array $items): self
    {
        $this->items = $items;
        return $this;
    }

    /**
     * @return int
     */
    public function getTotalPrice():int
    {
        return $this->totalPrice;
    }

    /**
     * @param int $totalPrice
     * @return Order
     */
    public function setTotalPrice(int $totalPrice): self
    {
        $this->totalPrice = $totalPrice;
        return $this;
    }

    /**
     * @return array
     */
    public function getDataForView():array
    {
        $itemArray = [];

        foreach ($this->getItems() as $item) {
            $quantity = $item->getQuantity();
            $item = $item->getProduct();
            $price = $item->getPrice()*$quantity;
            $tax = $price*(floatval($item->getTax()) / 100);
            $itemArray[] = [
                'id' => $item->getId(),
                'quantity' => $quantity,
                'total_price' => $price,
                'total_price_brutto' => $price + $tax,
                'tax' => $tax
            ];
        }
        return [
            'id' => $this->getId(),
            'items' => $itemArray,
            'total_price' => $this->getTotalPrice(),
            'total_price_brutto' => $this->getTotalPriceBrutto()
        ];
    }

    /**
     * @return int
     */
    public function getTotalPriceBrutto():int
    {
        return $this->totalPriceBrutto;
    }

    /**
     * @param $totalPriceBrutto
     */
    public function setTotalPriceBrutto(int $totalPriceBrutto): void
    {
        $this->totalPriceBrutto = $totalPriceBrutto;
    }
}
