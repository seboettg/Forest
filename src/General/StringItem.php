<?php
declare(strict_types=1);
/*
 * Copyright (C) 2019 Sebastian Böttger <seboettg@gmail.com>
 * You may use, distribute and modify this code under the
 * terms of the MIT license.
 *
 * You should have received a copy of the MIT license with
 * this file. If not, please visit: https://opensource.org/licenses/mit-license.php
 */

namespace Seboettg\Forest\General;

use Seboettg\Collection\Comparable\Comparable;

class StringItem implements ItemInterface
{
    /**
     * @var string
     */
    protected $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function setValue(string $value)
    {
        $this->value = $value;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function compareTo(Comparable $b)
    {
        /** @var StringItem $b */
        return strcasecmp($this->getValue(), $b->getValue());
    }

    public function __toString()
    {
        return (string)$this->value;
    }

    public function equals(ItemInterface $item): bool
    {
        return $this->compareTo($item) === 0;
    }
}
