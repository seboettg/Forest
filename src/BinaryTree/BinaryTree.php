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

use Countable;
use Seboettg\Forest\AVLTree\AVLNodeInterface;
use Seboettg\Forest\General\ItemInterface;
use Seboettg\Forest\General\TreeTraversalInterface;
use Seboettg\Forest\General\TreeNodeInterface;
use Seboettg\Forest\General\TreeTraversalTrait;

/**
 * Class BinaryTree
 * A binary tree is a recursive data structure where each node can have 2 children at most.
 *
 * @package Seboettg\Forest\BinaryTree
 */
class BinaryTree implements Countable, TreeTraversalInterface
{
    use TreeTraversalTrait;

    /**
     * @var TreeNodeInterface|BinaryNodeInterface|AVLNodeInterface
     */
    protected $root;

    /**
     * @var int
     */
    protected $elementCount = 0;

    /**
     * @param ItemInterface $value
     *
     * @return BinaryNode|null
     */
    public function search(ItemInterface $value): ?BinaryNodeInterface
    {
        return $this->searchRecursive($value, $this->root);
    }

    /**
     * @param ItemInterface $value
     * @param BinaryNodeInterface $node
     * @return BinaryNode
     */
    protected function searchRecursive(ItemInterface $value, BinaryNodeInterface $node = null): ?BinaryNodeInterface
    {
        if ($node === null) {
            return null;
        } else if ($node->getItem()->compareTo($value) === 0) {
            return $node;
        } else if ($node->getItem()->compareTo($value) >= 0) {
            return $this->searchRecursive($value, $node->getLeft());
        } else {
            return $this->searchRecursive($value, $node->getRight());
        }
    }

    /**
     * @param ItemInterface $value
     * @return TreeTraversalInterface
     */
    public function insert(ItemInterface $value): TreeTraversalInterface
    {
        ++$this->elementCount;
        if ($this->root === null) {
            $this->root = new BinaryNode($value);
        } else {
            $this->insertRecursive($this->root, $value);
        }
        return $this;
    }

    /**
     * @param BinaryNodeInterface $node
     * @param ItemInterface $value
     * @return void
     */
    private function insertRecursive(BinaryNodeInterface $node, ItemInterface $value): void
    {
        if ($node->getItem()->compareTo($value) >= 0) {
            if ($node->getLeft() === null) {
                $node->setLeft(new BinaryNode($value));
            } else {
                $this->insertRecursive($node->getLeft(), $value);
            }
        } else {
            if ($node->getRight() === null) {
                $node->setRight(new BinaryNode($value));
            } else {
                $this->insertRecursive($node->getRight(), $value);
            }
        }
    }

    /**
     * @return int number of nodes in the tree
     */
    public function count(): int
    {
        return $this->elementCount;
    }

    /**
     * @return int height of the tree
     */
    public function getHeight()
    {
        return $this->root->getHeight();
    }
}
