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

namespace Seboettg\Forest\General;

use Countable;
use ErrorException;
use Seboettg\Collection\Stack;

/**
 * Class Builder
 * @package Seboettg\Forest\General
 */
class GeneralTree implements Countable, TreeTraversalInterface
{
    use TreeTraversalTrait;

    /**
     * @var Stack
     */
    private $treeNodeStack;

    /**
     * @var string
     */
    private $itemType;

    /**
     * @var int
     */
    private $elementCount = 0;

    /**
     * @var TreeNodeInterface
     */
    private $root;

    /**
     * GeneralTree constructor.
     * @param string $itemType
     * @throws ErrorException
     */
    public function __construct(string $itemType)
    {
        if (!class_exists($itemType)) {
            throw new ErrorException("Could not find class $itemType");
        }
        $this->itemType = $itemType;
    }

    /**
     * @param mixed $value
     * @return GeneralTree
     */
    public function root($value)
    {
        $this->treeNodeStack = new Stack();
        $this->root = $this->nodeFactory($value);
        $this->treeNodeStack->push($this->root);
        return $this;
    }

    /**
     * Add a child to the node enter in its scope
     *
     * @param mixed $value
     * @return GeneralTree
     */
    public function subTree($value)
    {
        $node = $this->nodeFactory($value);
        $this->treeNodeStack->peek()->addChild($node);
        $this->treeNodeStack->push($node);
        return $this;
    }

    /**
     * @param mixed $value
     * @return GeneralTree
     */
    public function child($value)
    {
        $node = $this->nodeFactory($value);
        $this->treeNodeStack->peek()->addChild($node);
        return $this;
    }

    /**
     * @return GeneralTree
     */
    public function endSubTree()
    {
        $this->treeNodeStack->pop();
        return $this;
    }

    /**
     * @param mixed $value
     * @return TreeNodeInterface
     */
    private function nodeFactory($value): TreeNodeInterface
    {
        ++$this->elementCount;
        if (is_object($value) && get_class($value) === $this->itemType) {
            return new TreeNode($value);
        }
        $item = new $this->itemType($value);
        return new TreeNode($item);
    }

    /**
     * @return TreeNodeInterface
     */
    public function getNode(): ?TreeNodeInterface
    {
        return $this->treeNodeStack->peek();
    }

    /**
     * @return TreeNodeInterface
     */
    public function getRoot(): ?TreeNodeInterface
    {
        return $this->root;
    }

    /**
     * @inheritDoc
     */
    public function count()
    {
        return $this->elementCount;
    }
}
