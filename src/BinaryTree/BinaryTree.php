<?php
declare(strict_types=1);
/*
 * Trees: BinaryTree.php
 * User: Sebastian Böttger <seboettg@gmail.com>
 * created at 2019-02-16, 15:09
 */

namespace Seboettg\Forest\BinaryTree;

use Countable;
use Seboettg\Collection\ArrayList\ArrayListInterface;
use Seboettg\Collection\Comparable\Comparable;
use Seboettg\Collection\Queue;

/**
 * Class BinaryTree
 * A binary tree is a recursive data structure where each node can have 2 children at most.
 *
 * @package Seboettg\Trees\BinaryTree
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
    public function insert(Comparable $value)
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
    protected function insertRecursive(TreeNode $node, Comparable $value)
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
     * @param ArrayListInterface $target
     * @param int $orderStrategy
     */
    public function toArrayList(ArrayListInterface &$target, int $orderStrategy = self::TRAVERSE_IN_ORDER)
    {
        switch ($orderStrategy) {
            case self::TRAVERSE_IN_ORDER:
                $this->traverseInOrder($target, $this->root);
                break;
            case self::TRAVERSE_PRE_ORDER:
                $this->traversePreOrder($target, $this->root);
                break;
            case self::TRAVERSE_POST_ORDER:
                $this->traversePostOrder($target, $this->root);
                break;
            case self::TRAVERSE_LEVEL_ORDER:
                $queue = new Queue();
                $queue->enqueue($this->root);
                $this->traverseLevelOrder($target, $queue);
        }
    }

    /**
     * @param ArrayListInterface $target
     * @param TreeNode|null $node
     */
    protected function traverseInOrder(ArrayListInterface &$target, TreeNode $node = null)
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
    protected function traversePreOrder(ArrayListInterface &$target, TreeNode $node = null)
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
    protected function traversePostOrder(ArrayListInterface &$target, TreeNode $node = null)
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
    protected function traverseLevelOrder(ArrayListInterface &$target, Queue $queue)
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
    public function count()
    {
        return $this->elementCount;
    }
}
