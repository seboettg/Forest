<?php
declare(strict_types=1);
/*
 * Forest: Item.php
 * User: Sebastian Böttger <sebastian.boettger@thomascook.de>
 * created at 14.09.19, 17:09
 */

namespace Seboettg\Forest\General;

use Seboettg\Collection\Comparable\Comparable;

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
        }
        return $this->value < $b->getValue() ? -1 : 1;

    }

    public function equals(ItemInterface $item): bool
    {
        return $this->compareTo($item) === 0;
    }
}
