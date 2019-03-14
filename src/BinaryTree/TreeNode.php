<?php
declare(strict_types=1);
/*
 * Trees: TreeNode.php
 * User: Sebastian Böttger <seboettg@gmail.com>
 * created at 2019-02-16, 15:02
 */

namespace Seboettg\Forest\BinaryTree;

use Seboettg\Collection\Comparable\Comparable;

/**
 * Class TreeNode
 * @package Seboettg\Forest\BinaryTree
 */
class TreeNode
{
    /**
     * @var TreeNode
     */
    protected $left;

    /**
     * @var TreeNode
     */
    protected $right;

    /**
     * @var Comparable
     */
    protected $item;

    public function __construct(Comparable $item)
    {
        $this->item = $item;
    }

    /**
     * @return TreeNode
     */
    final public function getLeft(): ?TreeNode
    {
        return $this->left;
    }

    /**
     * @param TreeNode $left
     * @return void
     */
    final public function setLeft(TreeNode $left): void
    {
        $this->left = $left;
    }

    /**
     * @return TreeNode
     */
    final public function getRight(): ?TreeNode
    {
        return $this->right;
    }

    /**
     * @param TreeNode $right
     * @return void
     */
    final public function setRight(TreeNode $right): void
    {
        $this->right = $right;
    }

    /**
     * @return mixed
     */
    final public function getItem(): Comparable
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
}
