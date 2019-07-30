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
use Seboettg\Collection\Queue;
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
class BinaryTree implements Countable
{
    /**
     * The in-order traversal consists of first visiting the left sub-tree, then them self, and finally the
     * right sub-tree.
     */
    public const TRAVERSE_IN_ORDER = 0;

    /**
     * Pre-order traversal visits first them self, then the left subtree, and finally the right subtree.
     */
    public const TRAVERSE_PRE_ORDER = 1;

    /**
     * Post-order traversal visits the left subtree, the right subtree, and them self at the end.
     */
    public const TRAVERSE_POST_ORDER = 2;

    /**
     * Level-order is another strategy of traversal that visits all the nodes of a level before going to the next
     * level. This kind of traversal is also called Breadth-first and visits all the levels of the tree starting from
     * the root, and from left to right.
     */
    public const TRAVERSE_LEVEL_ORDER = 3;

    /**
     * @var TreeNode
     */
    protected $root;

    /**
     * @var int
     */
    protected $elementCount = 0;

    /**
     * @param Comparable $value
     *
     * @return TreeNode|null
     */
    public function search(Comparable $value): ?TreeNode
    {
        return $this->searchRecursive($value, $this->root);
    }

    /**
     * @param TreeNode $node
     * @param Comparable $value
     * @return TreeNode
     */
    protected function searchRecursive(Comparable $value, TreeNode $node = null): ?TreeNode
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
     * @return BinaryTree
     */
    public function insert(Comparable $value): BinaryTree
    {
        ++$this->elementCount;
        if ($this->root === null) {
            $this->root = new TreeNode($value);
        } else {
            $this->insertRecursive($this->root, $value);
        }
        return $this;
    }

    /**
     * @param TreeNode $node
     * @param Comparable $value
     * @return void
     */
    protected function insertRecursive(TreeNode $node, Comparable $value): void
    {
        if ($node->getItem()->compareTo($value) >= 0) {
            if ($node->getLeft() === null) {
                $node->setLeft(new TreeNode($value));
            } else {
                $this->insertRecursive($node->getLeft(), $value);
            }
        } else {
            if ($node->getRight() === null) {
                $node->setRight(new TreeNode($value));
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
     * @param ArrayListInterface $target
     * @param TreeNode|null $node
     */
    protected function traverseInOrder(ArrayListInterface &$target, TreeNode $node = null): void
    {
        if ($node !== null) {
            $this->traverseInOrder($target, $node->getLeft());
            $target->append($node->getItem());
            $this->traverseInOrder($target, $node->getRight());
        }
    }

    /**
     * @param ArrayListInterface $target
     * @param TreeNode|null $node
     */
    protected function traversePreOrder(ArrayListInterface &$target, TreeNode $node = null): void
    {
        if ($node !== null) {
            $target->append($node->getItem());
            $this->traversePreOrder($target, $node->getLeft());
            $this->traversePreOrder($target, $node->getRight());
        }
    }

    /**
     * @param ArrayListInterface $target
     * @param TreeNode|null $node
     */
    protected function traversePostOrder(ArrayListInterface &$target, TreeNode $node = null): void
    {
        if ($node !== null) {
            $this->traversePostOrder($target, $node->getLeft());
            $this->traversePostOrder($target, $node->getRight());
            $target->append($node->getItem());
        }
    }

    /**
     * @param ArrayListInterface $target
     * @param Queue $queue
     */
    protected function traverseLevelOrder(ArrayListInterface &$target, Queue $queue): void
    {
        while ($queue->count() > 0) {
            /** @var TreeNode $node */
            $node = $queue->dequeue();
            if ($node->getLeft() !== null) {
                $queue->enqueue($node->getLeft());
            }
            if ($node->getRight() !== null) {
                $queue->enqueue($node->getRight());
            }
            $target->append($node->getItem());
        }
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return $this->elementCount;
    }
}
