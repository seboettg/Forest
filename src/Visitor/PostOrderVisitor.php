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

use Seboettg\Collection\ArrayList;
use Seboettg\Collection\ArrayList\ArrayListInterface;
use Seboettg\Forest\General\TreeNodeInterface;

/**
 * Class PostOrderVisitor
 * Implements the tree traversal strategy Post-order.
 * In this traversal strategy, the root node is visited last. First we traverse the subtrees from left to right
 * and finally the root node.
 *
 * @package Seboettg\Forest\Visitor
 */
class PostOrderVisitor implements VisitorInterface
{
    /**
     * @param TreeNodeInterface $node
     * @return ArrayListInterface
     */
    public function visit(TreeNodeInterface $node): ArrayListInterface
    {
        $resultList = new ArrayList();
        if ($node !== null) {
            foreach($node->getChildren() as $child) {
                $resultList->merge($child->accept($this));
            }
            $resultList->append($node->getItem());
        }
        return $resultList;
    }
}
