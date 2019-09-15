<?php
declare(strict_types=1);
/*
 * Forest: TreeInterface.php
 * User: Sebastian Böttger <sebastian.boettger@thomascook.de>
 * created at 14.09.19, 17:38
 */

namespace Seboettg\Forest\General;

use Seboettg\Collection\ArrayList\ArrayListInterface;
use Seboettg\Collection\Comparable\Comparable;

interface TreeInterface
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
     * Post-order traversal visits the left subtree, the right subtree, and finally them self.
     */
    public const TRAVERSE_POST_ORDER = 2;

    /**
     * Level-order is another strategy of traversal that visits all the nodes of a level before going to the next
     * level. This kind of traversal is also called Breadth-first and visits all the levels of the tree starting from
     * the root, and from left to right.
     */
    public const TRAVERSE_LEVEL_ORDER = 3;

    /**
     * @param int $traversalStrategy
     * @return ArrayListInterface
     */
    public function toArrayList(int $traversalStrategy = self::TRAVERSE_IN_ORDER): ArrayListInterface;

    /**
     * @param Comparable $item
     * @return mixed
     */
    public function insert(Comparable $item): self;
}
