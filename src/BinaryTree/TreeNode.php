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
use Seboettg\Forest\General\TreeNodeInterface;
use Seboettg\Forest\Visitor\VisitorInterface;

/**
 * Class TreeNode
 * @package Seboettg\Forest\BinaryTree
 */
class TreeNode implements BinaryTreeNodeInterface
{
    /**
     * @var TreeNode[]
     */
    protected $children;

    /**
     * @var Comparable
     */
    protected $item;

    /**
     * @var TreeNode
     */
    protected $parent;

    public function __construct(Comparable $item)
    {
        $this->item = $item;
        $this->children["left"] = null;
        $this->children["right"] = null;
    }

    /**
     * @return TreeNode
     */
    final public function getLeft(): ?BinaryTreeNodeInterface
    {
        return $this->children["left"];
    }

    /**
     * @param TreeNode $left
     * @return void
     */
    final public function setLeft(TreeNode $left): void
    {
        $left->setParent($this);
        $this->children["left"] = $left;
    }

    /**
     * @return TreeNode
     */
    final public function getRight(): ?BinaryTreeNodeInterface
    {
        return $this->children["right"];
    }

    /**
     * @param TreeNode $right
     * @return void
     */
    final public function setRight(TreeNode $right): void
    {
        $right->setParent($this);
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
    final public function setItem(Comparable $item): void
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
     * @param TreeNode $parent
     */
    private function setParent(TreeNode $parent)
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
