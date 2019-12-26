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

namespace Seboettg\Forest;

use Countable;
use Seboettg\Forest\AVLTree\AVLNodeInterface;
use Seboettg\Forest\BinaryTree\BinaryNode;
use Seboettg\Forest\BinaryTree\BinaryNodeInterface;
use Seboettg\Forest\Item\ItemInterface;
use Seboettg\Forest\General\TreeTraversalInterface;
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
     * @var BinaryNodeInterface|AVLNodeInterface
     */
    protected $root;

    /**
     * @var int
     */
    protected $elementCount = 0;

    protected $itemType;

    public function __construct(?string $itemType = null)
    {
        $this->itemType = $itemType;
    }


    /**
     * @param ItemInterface $value
     *
     * @return BinaryNodeInterface|AVLNodeInterface
     */
    final public function search(ItemInterface $value): ?BinaryNodeInterface
    {
        return $this->searchRecursive($value, $this->root);
    }

    /**
     * @param ItemInterface $value
     * @param BinaryNodeInterface $node
     * @return BinaryNodeInterface|AVLNodeInterface
     */
    final protected function searchRecursive(ItemInterface $value, BinaryNodeInterface $node = null): ?BinaryNodeInterface
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
     * @param mixed $value
     * @return TreeTraversalInterface
     */
    public function insert($value): TreeTraversalInterface
    {
        ++$this->elementCount;
        if (!empty($this->itemType) && is_object($value) && get_class($value) === $this->itemType) {
            $this->insertItem($value);
        } else {

            if (empty($this->itemType)) {
                $this->insertItem($value);
            } else {
                $item = new $this->itemType($value);
                $this->insertItem($item);
            }
        }
        return $this;
    }

    /**
     * @param $value
     */
    protected function insertItem($value): void
    {
        if ($this->root === null) {
            $this->root = new BinaryNode($value);
        } else {
            $this->insertRecursive($this->root, $value);
        }
    }

    /**
     * @param BinaryNodeInterface $node
     * @param ItemInterface $value
     * @return void
     */
    final private function insertRecursive(BinaryNodeInterface $node, ItemInterface $value): void
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
    final public function count(): int
    {
        return $this->elementCount;
    }

    /**
     * @return int height of the tree
     */
    final public function getHeight()
    {
        return $this->root->getHeight();
    }

    /**
     * @return AVLNodeInterface
     */
    final public function getRootNode()
    {
        return $this->root;
    }
}
