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

use Seboettg\Collection\ArrayList\ArrayListInterface;
use Seboettg\Forest\Visitor\VisitorInterface;

class TreeNode implements TreeNodeInterface
{

    /**
     * @var null|TreeNode
     */
    protected $parent;

    /**
     * @var TreeNode[]
     */
    protected $children;

    /**
     * @var ItemInterface
     */
    protected $item;

    /**
     * TreeNode constructor.
     * @param ItemInterface $item
     */
    public function __construct(ItemInterface $item)
    {
        $this->children = [];
        $this->item = $item;
    }

    public function getParent(): ?TreeNodeInterface
    {
        return $this->parent;
    }

    private function setParent(TreeNode $parent): void
    {
        $this->parent = $parent;
    }

    /**
     * @param TreeNode $child
     */
    public function addChild(TreeNode $child): void
    {
        $child->setParent($this);
        $this->children[] = $child;
    }

    /**
     * @return TreeNode[]
     */
    public function getChildren(): array
    {
        return $this->children;
    }

    /**
     * @param mixed $identifier
     * @return TreeNode|null
     */
    public function getChild($identifier): ?TreeNode
    {
        foreach ($this->children as $child) {
            if ($identifier === $child->getItem()->getIdentifier()) {
                return $child;
            }
        }
        return null;
    }

    /**
     * @return ItemInterface
     */
    public function getItem(): ItemInterface
    {
        return $this->item;
    }

    /**
     * @return bool
     */
    public function isLeaf(): bool
    {
        return count($this->children) === 0;
    }
    /**
     * @return bool
     */
    public function isRoot(): bool
    {
        return $this->getParent() === null;
    }
    /**
     * @return bool
     */
    public function isChild(): bool
    {
        return $this->getParent() !== null;
    }

    /**
     * Returns the distance from the current node to the root.
     *
     * @return int
     */
    public function getLevel(): int
    {
        if ($this->isRoot()) {
            return 0;
        }
        return $this->getParent()->getLevel() + 1;
    }

    /**
     * Returns the height of the tree from current node
     *
     * @return int
     */
    public function getHeight(): int
    {
        if ($this->isLeaf()) {
            return 0;
        }
        $heights = [];
        foreach ($this->getChildren() as $child) {
            $heights[] = $child->getHeight();
        }
        return max($heights) + 1;
    }

    /**
     * For visitors
     * @param VisitorInterface $visitor
     * @return ArrayListInterface
     */
    public function accept(VisitorInterface $visitor): ArrayListInterface
    {
        return $visitor->visit($this);
    }
}
