<?php
namespace Recruitment\Entity;


class Order
{
    private $id;
    private $items;
    private $totalPrice;
    private $totalPriceBrutto;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return Order
     */
    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @param mixed $items
     * @return Order
     */
    public function setItems(array $items): self
    {
        $this->items = $items;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTotalPrice()
    {
        return $this->totalPrice;
    }

    /**
     * @param mixed $totalPrice
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
        foreach ($this->getItems() as $item)
        {
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
     * @return mixed
     */
    public function getTotalPriceBrutto()
    {
        return $this->totalPriceBrutto;
    }

    /**
     * @param mixed $totalPriceBrutto
     */
    public function setTotalPriceBrutto($totalPriceBrutto): void
    {
        $this->totalPriceBrutto = $totalPriceBrutto;
    }
}