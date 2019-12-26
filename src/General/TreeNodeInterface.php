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

use Seboettg\Collection\ArrayList\ArrayListInterface;
use Seboettg\Forest\Item\ItemInterface;
use Seboettg\Forest\Visitor\VisitorInterface;

interface TreeNodeInterface
{
    /**
     * @return TreeNodeInterface[]
     */
    public function getChildren(): array;

    /**
     * @return TreeNodeInterface
     */
    public function getParent(): ?TreeNodeInterface;

    /**
     * @param TreeNodeInterface $node
     */
    public function setParent(TreeNodeInterface $node): void;

    /**
     * @return int
     */
    public function getHeight(): int;

    /**
     * @return int
     */
    public function getLevel(): int;

    /**
     * @return ItemInterface
     */
    public function getItem(): ?ItemInterface;

    /**
     * @return bool
     */
    public function isChild(): bool;

    /**
     * @return bool
     */
    public function isRoot(): bool;

    /**
     * @return bool
     */
    public function isLeaf(): bool;

    /**
     * For visitors
     * @param VisitorInterface $visitor
     * @return ArrayListInterface
     */
    public function accept(VisitorInterface $visitor): ArrayListInterface;
}
