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

namespace Seboettg\Forest\AVLTree;

use Seboettg\Forest\BinaryTree\BinaryTree;
use Seboettg\Forest\General\ItemInterface;
use Seboettg\Forest\General\TreeTraversalInterface;

/**
 * Class AVLTree
 *
 * @package Seboettg\Forest\AVLTree
 */
class AVLTree extends BinaryTree
{
    private $rebalance = false;

    /**
     * @param ItemInterface $value
     * @return AVLTree
     */
    public function insert(ItemInterface $value): TreeTraversalInterface
    {
        ++$this->elementCount;
        if ($this->root === null) {
            $this->root = new AVLNode($value);
        } else {
            $this->root = $this->insertNode($this->root, $value);
        }
        return $this;
    }

    /**
     * @param AVLNodeInterface $node
     * @param ItemInterface $item
     * @return AVLNode|AVLNodeInterface
     */
    protected function insertNode(AVLNodeInterface $node, ItemInterface $item)
    {
        if ($node->getItem()->compareTo($item) === 0) {
            return $node;
        } else if ($node->getItem()->compareTo($item) < 0) {
            return $this->insertRight($node, $item);
        } else {
            return $this->insertLeft($node, $item);
        }
    }

    /**
     * @param AVLNodeInterface $node
     * @return AVLNodeInterface
     */
    private function rotateLeft(AVLNodeInterface $node): AVLNodeInterface
    {
        $tmp = $node->getRight();
        $node->setRight($node->getRight()->getLeft());
        $tmp->setLeft($node);
        return $tmp;
    }

    /**
     * @param AVLNodeInterface $node
     * @return AVLNodeInterface
     */
    private function rotateRight(AVLNodeInterface $node): AVLNodeInterface
    {
        $tmp = $node->getLeft();
        $node->setLeft($node->getLeft()->getRight());
        $tmp->setRight($node);
        return $tmp;
    }

    /**
     * @param AVLNodeInterface $node
     * @param ItemInterface $item
     *
     * @return AVLNode
     */
    private function insertRight(AVLNodeInterface $node, ItemInterface $item): AVLNodeInterface
    {
        if ($node->getRight() !== null) {
            $node->setRight($this->insertNode($node->getRight(), $item)); //recursive insertion of the item in the right subtree
            if ($this->rebalance) {
                switch ($node->getBalance()) {
                    case 1:
                        if ($node->getRight()->getBalance() === 1) {
                            //rotation left
                            $tmp = $this->rotateLeft($node);
                            $tmp->getLeft()->setBalance(0);
                        } else {
                            //double rotation left-right
                            $balance = $node->getRight()->getLeft()->getBalance();
                            $node->setRight($this->rotateRight($node->getRight()));
                            $tmp = $this->rotateLeft($node);
                            $tmp->getRight()->setBalance($balance === -1 ? 1 : 0);
                            $tmp->getLeft()->setBalance($balance === 1 ? -1 : 0);
                        }
                        $tmp->setBalance(0);
                        $this->rebalance = false;
                        return $tmp;
                    case 0:
                        $node->setBalance(1);
                        return $node;
                    case -1:
                        $node->setBalance(0);
                        $this->rebalance = false;
                        return $node;
                }
            } else {
                return $node;
            }
        } else {
            //create new node
            $newNode = new AVLNode($item);
            $node->setRight($newNode);
            $node->setBalance($node->getBalance() + 1);
            $this->rebalance = $node->getBalance() >= 1;
            return $node;
        }
        return null;
    }

    /**
     * @param AVLNodeInterface $node
     * @param ItemInterface $item
     * @return AVLNodeInterface
     */
    private function insertLeft(AVLNodeInterface $node, ItemInterface $item): AVLNodeInterface
    {
        if ($node->getLeft() !== null) {
            $node->setLeft($this->insertNode($node->getLeft(), $item));
            if ($this->rebalance) {
                switch ($node->getBalance()) {
                    case -1:
                        if ($node->getLeft()->getBalance() === -1) {
                            $tmp = $this->rotateRight($node);
                            $tmp->getRight()->setBalance(0);
                        } else {
                            //double rotation right-left
                            $balance = $node->getLeft()->getRight()->getBalance();
                            $node->setLeft($this->rotateLeft($node->getLeft()));
                            $tmp = $this->rotateRight($node);
                            $tmp->getRight()->setBalance($balance === -1 ? 0 : 1);
                            $tmp->getLeft()->setBalance($balance === 1 ? -1 : 0);

                        }
                        $tmp->setBalance(0);
                        $this->rebalance = false;
                        return $tmp;
                    case 0:
                        $node->setBalance(-1);
                        return $node;
                    case 1:
                        $node->setBalance(0);
                        $this->rebalance = false;
                        return $node;
                }
            } else {
                return $node;
            }
        } else {
            //create new node
            $newNode = new AVLNode($item);
            $node->setLeft($newNode);
            $node->setBalance($node->getBalance() - 1);
            $this->rebalance = $node->getBalance() <= -1;
            return $node;
        }
        return null;
    }

    /**
     * @return AVLNodeInterface
     */
    public function getRootNode()
    {
        return $this->root;
    }
}
