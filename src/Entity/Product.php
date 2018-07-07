<?php

namespace Recruitment\Entity;

use Recruitment\Entity\Exception\InvalidQuantityValueException;
use Recruitment\Entity\Exception\InvalidUnitPriceException;

class Product
{
    private $unitPrice;
    private $tax;
    private $minimumQuantity = 1;
    private $name;
    private $id;

    /**
     * @param int $unitPrice
     * @return Product
     * @throws InvalidUnitPriceException
     */
    public function setUnitPrice(int $unitPrice)
    {
        if ($unitPrice > 0) {
            $this->unitPrice = $unitPrice;
            return $this;
        } else {
            throw new InvalidUnitPriceException();
        }
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->unitPrice;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param $name
     * @return Product
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return int
     */
    public function getMinimumQuantity(): int
    {
        return $this->minimumQuantity;
    }

    /**
     * @param int $minimumQuantity
     * @return Product
     */
    public function setMinimumQuantity(int $minimumQuantity)
    {
        if ($minimumQuantity < 1) {
            throw new \InvalidArgumentException();
        } else {
            $this->minimumQuantity = $minimumQuantity;
            return $this;
        }
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $int
     * @return Product
     */
    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTax()
    {
        return $this->tax;
    }

    /**
     * @param string $tax
     * @return Product
     */
    public function setTax(string $tax):self
    {
        $this->tax = $tax;
        return $this;
    }
}
