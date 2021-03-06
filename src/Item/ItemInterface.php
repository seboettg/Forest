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

namespace Seboettg\Forest\Item;

use Seboettg\Collection\Comparable\Comparable;

/**
 * Interface ItemInterface
 * @package Seboettg\Forest\Tree
 */
interface ItemInterface extends Comparable
{
    /**
     * @param ItemInterface $item
     * @return bool
     */
    public function equals(ItemInterface $item): bool;

    /**
     * @param Comparable|ItemInterface $b
     * @return int
     */
    public function compareTo(Comparable $b): int;
}
