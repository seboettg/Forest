<?php
/*
 * Forest: Item.php
 * User: Sebastian Böttger <sebastian.boettger@thomascook.de>
 * created at 14.09.19, 17:09
 */

namespace Seboettg\Forest\Test\Helper;



use Seboettg\Collection\Comparable\Comparable;
use Seboettg\Forest\General\ItemInterface;

class Item implements ItemInterface {

    protected $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function compareTo(Comparable $b)
    {
        /** @var Item $b */
        if ($this->value === $b->getValue()) {
            return 0;
        } else {
            return $this->value < $b->getValue() ? -1 : 1;
        }
    }

    public function equals(ItemInterface $item): bool
    {
        return $this->compareTo($item) === 0;
    }
}
