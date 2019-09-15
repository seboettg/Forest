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

use Seboettg\Collection\ArrayList\ArrayListInterface;
use Seboettg\Collection\Comparable\Comparable;
use Seboettg\Forest\General\ItemInterface;
use Seboettg\Forest\General\TreeNode;
use Seboettg\Forest\General\TreeNodeInterface;
use Seboettg\Forest\Visitor\VisitorInterface;

/**
 * Class BinaryNode
 * @package Seboettg\Forest\BinaryTree
 */
class BinaryNode extends TreeNode implements BinaryNodeInterface
{

    public function __construct(ItemInterface $item)
    {
        parent::__construct($item);
        $this->children["left"] = null;
        $this->children["right"] = null;
    }

    /**
     * @return BinaryNode
     */
    final public function getLeft(): ?BinaryNodeInterface
    {
        return $this->children["left"];
    }

    /**
     * @param BinaryNodeInterface $left
     * @return void
     */
    final public function setLeft(?BinaryNodeInterface $left): void
    {
        $left->setParent($this);
        $this->children["left"] = $left;
    }

    /**
     * @return BinaryNode
     */
    final public function getRight(): ?BinaryNodeInterface
    {
        return $this->children["right"];
    }

    /**
     * @param BinaryNodeInterface $right
     * @return void
     */
    final public function setRight(?BinaryNodeInterface $right): void
    {
        if ($right !== null) {
            $right->setParent($this);
        }
        $this->children["right"] = $right;
    }

    /**
     * @return mixed
     */
    final public function getItem(): ItemInterface
    {
        return $this->item;
    }

    /**
     * @codeCoverageIgnore
     * @param mixed $item
     * @return void
     */
    final public function setItem(ItemInterface $item): void
    {
        $this->item = $item;
    }

    /**
     * @return TreeNodeInterface[]
     */
    public function getChildren(): array
    {
        return array_filter($this->children, function($item) {
            return !empty($item);
        });
    }

    /**
     * @return TreeNodeInterface
     */
    public function getParent(): TreeNodeInterface
    {
        return $this->parent;
    }

    /**
     * @param TreeNodeInterface $parent
     */
    public function setParent(TreeNodeInterface $parent): void
    {
        $this->parent = $parent;
    }

    /**
     * For visitors
     * @param VisitorInterface $visitor
     * @return ArrayListInterface
     */
    public function accept(VisitorInterface $visitor): ArrayListInterface
    {
        return $visitor->visit($this);
    }
}
