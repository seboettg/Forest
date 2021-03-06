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

namespace Seboettg\Forest\Visitor;

use InvalidArgumentException;
use Seboettg\Collection\ArrayList;
use Seboettg\Collection\ArrayList\ArrayListInterface;
use Seboettg\Forest\BinaryTree\BinaryNodeInterface;
use Seboettg\Forest\General\TreeNodeInterface;

/**
 * Class InOrderVisitor
 * Implements the tree traversal strategy In-order.
 * In this traversal strategy, the left subtree is visited first, then the root and later the right sub-tree.
 * If a binary tree is traversed in-order, the output will produce sorted key values in an ascending order.
 *
 * @package Seboettg\Forest\Visitor
 */
class InOrderVisitor implements VisitorInterface
{

    public function visit(TreeNodeInterface $node): ArrayListInterface
    {
        if (!$node instanceof BinaryNodeInterface) {
            throw new InvalidArgumentException(BinaryNodeInterface::class . " expected, got " . get_class($node) . ".");
        }
        $resultList = new ArrayList();
        if ($node !== null) {
            $left = $node->getLeft();
            $right = $node->getRight();
            if ($left !== null) {
                $resultList->merge($left->accept($this));
            }
            $resultList->append($node->getItem());
            if ($right !== null) {
                $resultList->merge($right->accept($this));
            }
        }
        return $resultList;
    }
}
