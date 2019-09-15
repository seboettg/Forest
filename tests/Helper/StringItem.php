<?php
/*
 * Forest: StringItem.php
 * User: Sebastian Böttger <sebastian.boettger@thomascook.de>
 * created at 14.09.19, 17:10
 */

namespace Seboettg\Forest\Test\Helper;

use Seboettg\Collection\Comparable\Comparable;

class StringItem extends Item {

    public function compareTo(Comparable $b)
    {
        /** @var StringItem $b */
        return strcasecmp($this->getValue(), $b->getValue());
    }

    public function __toString()
    {
        return (string)$this->value;
    }
}
