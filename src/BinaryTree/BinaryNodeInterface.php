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

namespace Seboettg\Forest\BinaryTree;

use Seboettg\Forest\General\TreeNodeInterface;

interface BinaryNodeInterface extends TreeNodeInterface
{
    /**
     * @return BinaryNodeInterface
     */
    public function getLeft();

    /**
     * @return BinaryNodeInterface
     */
    public function getRight();

    /**
     * @param BinaryNodeInterface|null $node
     */
    public function setRight(?BinaryNodeInterface $node): void;

    /**
     * @param BinaryNodeInterface|null $node
     */
    public function setLeft(?BinaryNodeInterface $node): void;
}
