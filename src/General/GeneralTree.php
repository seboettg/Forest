<?php
/*
 * Forest: Builder.php
 * User: Sebastian Böttger <sebastian.boettger@thomascook.de>
 * created at 01.12.19, 21:28
 */

namespace Seboettg\Forest\General;

use Countable;
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
    private $elementCount;

    /**
     * @var TreeNodeInterface
     */
    private $root;

    public function __construct(string $itemType)
    {
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
        ++$this->elementCount;
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
        ++$this->elementCount;
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
        ++$this->elementCount;
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
     * @param $value
     * @return TreeNodeInterface
     */
    private function nodeFactory($value)
    {
        $item = new $this->itemType($value);
        return new TreeNode($item);
    }

    /**
     * @return TreeNodeInterface
     */
    public function getNode()
    {
        return $this->treeNodeStack->peek();
    }

    /**
     * @return TreeNodeInterface
     */
    public function getRoot()
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
