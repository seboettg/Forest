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

interface TreeTraversalInterface
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

}
