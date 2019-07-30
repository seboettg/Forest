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
use Seboettg\Forest\BinaryTree\BinaryTreeNodeInterface;
use Seboettg\Forest\General\TreeNodeInterface;

class InOrderVisitor implements VisitorInterface
{

    public function visit(TreeNodeInterface $node): ArrayListInterface
    {
        if (!$node instanceof BinaryTreeNodeInterface) {
            throw new InvalidArgumentException(BinaryTreeNodeInterface::class . " expected, got " . get_class($node) . ".");
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
