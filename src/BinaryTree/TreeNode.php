<?php
declare(strict_types=1);
/*
 * Trees: TreeNode.php
 * User: Sebastian Böttger <seboettg@gmail.com>
 * created at 2019-02-16, 15:02
 */

namespace Seboettg\Forest\BinaryTree;

use Seboettg\Collection\Comparable\Comparable;

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
    public function getLeft(): ?TreeNode
    {
        return $this->left;
    }

    /**
     * @param TreeNode $left
     */
    public function setLeft(TreeNode $left)
    {
        $this->left = $left;
    }

    /**
     * @return TreeNode
     */
    public function getRight(): ?TreeNode
    {
        return $this->right;
    }

    /**
     * @param TreeNode $right
     */
    public function setRight(TreeNode $right)
    {
        $this->right = $right;
    }

    /**
     * @return mixed
     */
    public function getItem(): Comparable
    {
        return $this->item;
    }

    /**
     * @codeCoverageIgnore
     * @param mixed $item
     */
    public function setItem(Comparable $item)
    {
        $this->item = $item;
    }
}
