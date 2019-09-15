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

namespace Seboettg\Forest\Visitor;

use Seboettg\Collection\ArrayList;
use Seboettg\Collection\ArrayList\ArrayListInterface;
use Seboettg\Collection\Queue;
use Seboettg\Forest\BinaryTree\BinaryNode;
use Seboettg\Forest\General\TreeNodeInterface;

class LevelOrderVisitor implements VisitorInterface
{

    public function visit(TreeNodeInterface $node): ArrayListInterface
    {
        $result = new ArrayList();
        $queue = new Queue();
        $queue->enqueue($node);
        return $this->traverseLevelOrder($result, $queue);
    }

    /**
     * @param ArrayListInterface $target
     * @param Queue $queue
     * @return ArrayListInterface
     */
    private function traverseLevelOrder(ArrayListInterface $target, Queue $queue): ArrayListInterface
    {
        while ($queue->count() > 0) {
            /** @var BinaryNode $node */
            $node = $queue->dequeue();
            foreach ($node->getChildren() as $child) {
                $queue->enqueue($child);
            }
            $target->append($node->getItem());
        }
        return $target;
    }
}
