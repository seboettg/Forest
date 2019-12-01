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
use Seboettg\Collection\ArrayList;
use Seboettg\Collection\ArrayList\ArrayListInterface;
use Seboettg\Collection\Comparable\Comparable;
use Seboettg\Forest\AVLTree\AVLNodeInterface;
use Seboettg\Forest\General\TreeInterface;
use Seboettg\Forest\General\TreeNodeInterface;
use Seboettg\Forest\Visitor\InOrderVisitor;
use Seboettg\Forest\Visitor\LevelOrderVisitor;
use Seboettg\Forest\Visitor\PostOrderVisitor;
use Seboettg\Forest\Visitor\PreOrderVisitor;

/**
 * Class BinaryTree
 * A binary tree is a recursive data structure where each node can have 2 children at most.
 *
 * @package Seboettg\Forest\BinaryTree
 */
class BinaryTree implements Countable, TreeInterface
{

    /**
     * @var TreeNodeInterface|BinaryNodeInterface|AVLNodeInterface
     */
    protected $root;

    /**
     * @var int
     */
    protected $elementCount = 0;

    /**
     * @param Comparable $value
     *
     * @return BinaryNode|null
     */
    public function search(Comparable $value): ?BinaryNodeInterface
    {
        return $this->searchRecursive($value, $this->root);
    }

    /**
     * @param Comparable $value
     * @param BinaryNodeInterface $node
     * @return BinaryNode
     */
    protected function searchRecursive(Comparable $value, BinaryNodeInterface $node = null): ?BinaryNodeInterface
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
     * @param Comparable $value
     * @return TreeInterface
     */
    public function insert(Comparable $value): TreeInterface
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
     * @param Comparable $value
     * @return void
     */
    private function insertRecursive(BinaryNodeInterface $node, Comparable $value): void
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
     * @param int $orderStrategy
     * @return ArrayListInterface
     */
    public function toArrayList(int $orderStrategy = self::TRAVERSE_IN_ORDER): ArrayListInterface
    {
        $result = new ArrayList();
        switch ($orderStrategy) {
            case self::TRAVERSE_IN_ORDER:
                $result = $this->root->accept(new InOrderVisitor());
                break;
            case self::TRAVERSE_PRE_ORDER:
                $result = $this->root->accept(new PreOrderVisitor());
                break;
            case self::TRAVERSE_POST_ORDER:
                $result = $this->root->accept(new PostOrderVisitor());
                break;
            case self::TRAVERSE_LEVEL_ORDER:
                $result = $this->root->accept(new LevelOrderVisitor());
        }
        return $result;
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
