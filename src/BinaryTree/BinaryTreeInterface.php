<?php
/*
 * Forest: BinaryTreeInterface.php
 * User: Sebastian Böttger <sebastian.boettger@thomascook.de>
 * created at 24.01.20, 08:55
 */

namespace Seboettg\Forest\BinaryTree;

use Countable;
use Seboettg\Forest\General\TreeTraversalInterface;
use Seboettg\Forest\Item\ItemInterface;

/**
 * Interface BinaryTreeInterface
 * @package Seboettg\Forest\BinaryTree
 */
interface BinaryTreeInterface extends TreeTraversalInterface, Countable
{
    /**
     * @param ItemInterface $item
     * @return BinaryNodeInterface|null
     */
    public function search(ItemInterface $item): ?BinaryNodeInterface;

    /**
     * @param $value
     * @return BinaryTreeInterface
     */
    public function insert($value): BinaryTreeInterface;

    /**
     * @param $value
     * @return BinaryTreeInterface
     */
    public function remove($value): BinaryTreeInterface;
}
