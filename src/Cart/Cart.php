<?php

namespace Recruitment\Cart;

use Recruitment\Entity\Order;
use Recruitment\Entity\Product;

class Cart
{
    private $product;
    private $items;

    /**
     * @return mixed
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @param mixed $product
     */
    public function setProduct($product): void
    {
        $this->product = $product;
    }

    /**
     * @param $product
     * @param int $quantity
     * @return Cart
     */
    public function addProduct(Product $product, int $quantity = null):self
    {
        if ($quantity === null) {
            $quantity = $product->getMinimumQuantity();
        }
        if ($this->checkProductExist($product)) {
            $existProduct = $this->items[$this->getProductIndex($product)];
            $existProduct->setQuantity($existProduct->getQuantity() + $quantity);
        } else {
            $item = new Item($product, $quantity);
            $this->items[] = $item;
        }

        return $this;
    }

    /**
     * @return mixed
     */
    public function getItems()
    {
        return $this->items;
    }

    public function getTotalPrice()
    {
        $totalPrice = 0;

        foreach ($this->items as $item) {
            $totalPrice += $item->getProduct()->getPrice() * $item->getQuantity();
        }

        return $totalPrice;
    }

    /**
     * @return int
     */
    public function getTotalPriceBrutto()
    {
        $totalPriceBrutto = 0;

        foreach ($this->items as $item) {
            $bruttoPrice = $this->getBruttoPriceSingleProduct($item->getProduct());
            $totalPriceBrutto += $bruttoPrice;
        }

        return intval($totalPriceBrutto);
    }

    /**
     * @param Product $product
     * @return int
     */
    public function getBruttoPriceSingleProduct(Product $product)
    {
        $item = $this->items[$this->getProductIndex($product)];
        $product = $item->getProduct();
        return intval($product->getPrice() + $this->getTaxValueSingleProduct($product))*$item->getQuantity();
    }

    /**
     * @param Product $product
     * @return int
     */
    public function getTaxValueSingleProduct(Product $product)
    {
        return intval(($product->getPrice()*(floatval($product->getTax()) / 100)));
    }



    /**
     * @param int $number
     * @return Cart
     */
    public function getItem(int $number):self
    {
        if (isset($this->items[$number])) {
            $this->setProduct($this->items[$number]->getProduct());
        } else {
            throw new \OutOfBoundsException();
        }
        return $this;
    }

    /**
     * @param Product $product
     * @return Cart
     */
    public function removeProduct(Product $product):self
    {
        if ($this->checkProductExist($product)) {
            unset($this->items[$this->getProductIndex($product)]);
            $this->items = array_values($this->items);
        }

        return $this;
    }

    /**
     * @param Product $product
     * @return int
     */
    private function getProductIndex(Product $product):int
    {
        for ($x=0; $x<sizeof($this->items); $x++) {
            if ($this->getItem($x)->getProduct()->getId() === $product->getId()) {
                return $x;
            }
        }
    }

    /**
     * @param Product $product
     * @return bool
     */
    private function checkProductExist(Product $product) :bool
    {
        if (!empty($this->items)) {
            for ($x=0; $x<sizeof($this->items); $x++) {
                if ($this->getItem($x)->getProduct()->getId() === $product->getId()) {
                    return true;
                } else {
                    return false;
                }
            }
        } else {
            return false;
        }
    }

    /**
     * @param Product $product
     * @param $quantity
     * @return Cart
     */
    public function setQuantity(Product $product, $quantity):self
    {
        if ($this->checkProductExist($product)) {
            $this->items[$this->getProductIndex($product)]->setQuantity($quantity);
        }
        return $this;
    }

    /**
     * @return int
     */
    public function getQuantity():int
    {
        return $this->items[$this->getProductIndex($this->product)]->getQuantity();
    }

    public function checkout(int $id)
    {
        $order = new Order();
        $order->setId($id);
        $order->setItems($this->items);
        $order->setTotalPrice($this->getTotalPrice());
        $order->setTotalPriceBrutto($this->getTotalPriceBrutto());
        $this->clearCart();
        return $order;
    }

    private function clearCart():void
    {
        $this->items = [];
    }
}
