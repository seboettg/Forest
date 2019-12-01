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

namespace Seboettg\Forest\AVLTree;

use Seboettg\Forest\BinaryTree\BinaryNode as BinaryTreeNode;

/**
 * Class AVLNode
 *
 * @package Seboettg\Forest\AVLTree
 */
class AVLNode extends BinaryTreeNode implements AVLNodeInterface
{

    /**
     * @var int
     */
    private $balance = 0;

    public function getBalance(): int
    {
        return $this->balance;
    }

    public function setBalance(int $balance): void
    {
        $this->balance = $balance;
    }
}
