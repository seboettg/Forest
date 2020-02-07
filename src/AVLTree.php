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

use Seboettg\Forest\BinaryTree\BinaryNode;
use Seboettg\Forest\BinaryTree\BinaryNodeInterface;
use Seboettg\Forest\Item\ItemInterface;

/**
 * Class AVLTree
 *
 * @package Seboettg\Forest\AVLTree
 */
class AVLTree extends BinaryTree
{
    protected function insertItem($value): void
    {
        if ($this->root === null) {
            $this->root = new BinaryNode($value);
        } else {
            $this->root = $this->insertNode($this->root, $value);
        }
    }

    /**
     * @param BinaryNodeInterface $node
     * @param ItemInterface $item
     * @return BinaryNode|BinaryNodeInterface
     */
    final protected function insertNode(?BinaryNodeInterface $node, ItemInterface $item): BinaryNodeInterface
    {
        if (null === $node) {
            return new BinaryNode($item);
        }
        if ($item->compareTo($node->getItem()) < 0) {
            $node->setLeft($this->insertNode($node->getLeft(), $item));
        } else {
            if ($item->compareTo($node->getItem()) > 0) {
                $node->setRight($this->insertNode($node->getRight(), $item));
            } else {
                return $node;
            }
        }

        if ($this->getBalance($node) > 1 && $item->compareTo($node->getLeft()->getItem()) < 0) {
            return $this->rotateRight($node);
        }
        $this->rebalance($item, $node);
        return $node;
    }

    /**
     * @param BinaryNodeInterface|null $node
     * @return int
     */
    protected function getBalance(?BinaryNodeInterface $node): int
    {
        $balanceLeft = null !== $node->getLeft() ? $node->getLeft()->getHeight() : 0;
        $balanceRight = null !== $node->getRight() ? $node->getRight()->getHeight() : 0;
        return $balanceLeft - $balanceRight;
    }

    /**
     * @param BinaryNodeInterface $node
     * @return BinaryNodeInterface
     */
    final private function rotateLeft(BinaryNodeInterface $node): BinaryNodeInterface
    {
        $tmp = $node->getRight();
        $node->setRight($node->getRight()->getLeft());
        $tmp->setLeft($node);
        return $tmp;
    }

    /**
     * @param BinaryNodeInterface $node
     * @return BinaryNodeInterface
     */
    final private function rotateRight(BinaryNodeInterface $node): BinaryNodeInterface
    {
        $tmp = $node->getLeft();
        $node->setLeft($node->getLeft()->getRight());
        $tmp->setRight($node);
        return $tmp;
    }

    /**
     * @param ItemInterface $item
     * @param BinaryNodeInterface|null $node
     */
    protected function removeItemRecursive(ItemInterface $item, ?BinaryNodeInterface &$node = null): void
    {
        parent::removeItemRecursive($item, $node);
        $this->rebalance($item, $node);
    }

    /**
     * @param BinaryNodeInterface $node
     */
    protected function reassignSubtree(BinaryNodeInterface &$node): void
    {
        if (empty($node->getLeft()) && empty($node->getRight())) { //no children?
            $node = null; // just unset the node and return
            return;
        }
        if (empty($node->getRight())) { // is there something on the right?
            $tmp = $node->getLeft(); // if not, return left node
            $tmp->setParent(null);
            $node = $tmp;
        } else {
            if (empty($node->getLeft())) { // is there something on the left?
                $tmp = $node->getRight(); // if not, return right node
                $tmp->setParent(null);
                $node = $tmp;
            } else { // left and right?
                $tmp = $node->getRight(); //keep right in mind
                $this->rebalance($node->getItem(), $tmp);
                $leftMostLeaf = $this->getLeftMostLeaf($tmp); // get the leftmost leaf of the right subtree
                $leftMostLeaf->setLeft($node->getLeft());  // append the left subtree to the leftmost leaf of the right subtree
                $node = $tmp;
            }
        }

    }

    /**
     * @param ItemInterface $item
     * @param BinaryNodeInterface|null $node
     */
    protected function rebalance(ItemInterface $item, ?BinaryNodeInterface &$node): void
    {
        $balance = $this->getBalance($node);
        if ($balance > 1) {
            // left left
            if ($item->compareTo($node->getLeft()->getItem()) < 0) {
                $node = $this->rotateRight($node);
            }
            // left right
            if ($item->compareTo($node->getLeft()->getItem()) > 0) {
                $node->setLeft($this->rotateLeft($node->getLeft()));
                $node = $this->rotateRight($node);
            }
        }
        if ($balance < -1) {
            // right right
            if ($item->compareTo($node->getRight()->getItem()) > 0) {
                $node = $this->rotateLeft($node);
            }
            // right left
            if ($item->compareTo($node->getRight()->getItem()) < 0) {
                $node->setRight($this->rotateRight($node->getRight()));
                $node = $this->rotateLeft($node);
            }
        }
    }
}
