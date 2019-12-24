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

class IntegerItem implements ItemInterface {

    /**
     * @var int
     */
    protected $value;

    /**
     * Item constructor.
     * @param int $value
     */
    public function __construct(int $value)
    {
        $this->value = $value;
    }

    /**
     * @return int
     */
    public function getValue(): int
    {
        return $this->value;
    }

    /**
     * @param Comparable $b
     * @return int
     */
    public function compareTo(Comparable $b): int
    {
        /** @var IntegerItem $b */
        if ($this->value === $b->getValue()) {
            return 0;
        }
        return $this->value < $b->getValue() ? -1 : 1;

    }

    /**
     * @param ItemInterface $item
     * @return bool
     */
    public function equals(ItemInterface $item): bool
    {
        return $this->compareTo($item) === 0;
    }
}
