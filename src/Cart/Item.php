<?php

namespace Recruitment\Cart;

use Recruitment\Cart\Exception\QuantityTooLowException;
use Recruitment\Entity\Product;

class Item
{
    private $product;
    private $quantity;

    public function __construct(Product $product, int $quantity)
    {
        if ($product->getMinimumQuantity() > $quantity) {
            throw new \InvalidArgumentException();
        } else {
            $this->product = $product;
            $this->quantity = $quantity;
        }
    }

    /**
     * @return Product
     */
    public function getProduct(): Product
    {
        return $this->product;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @return int
     */
    public function getTotalPrice() :int
    {
        return ($this->product->getPrice() * $this->quantity);
    }

    /**
     * @param int $quantity
     */
    public function setQuantity(int $quantity)
    {
        if ($this->product->getMinimumQuantity() > $quantity) {
            throw new QuantityTooLowException();
        } else {
            $this->quantity = $quantity;
        }
    }
}
