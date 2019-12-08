<?php
/*
 * Copyright (C) 2019 Sebastian Böttger <seboettg@gmail.com>
 * You may use, distribute and modify this code under the
 * terms of the MIT license.
 *
 * You should have received a copy of the MIT license with
 * this file. If not, please visit: https://opensource.org/licenses/mit-license.php
 */

namespace Seboettg\Forest\General;


use Seboettg\Collection\ArrayList;
use Seboettg\Collection\ArrayList\ArrayListInterface;
use Seboettg\Forest\Visitor\InOrderVisitor;
use Seboettg\Forest\Visitor\LevelOrderVisitor;
use Seboettg\Forest\Visitor\PostOrderVisitor;
use Seboettg\Forest\Visitor\PreOrderVisitor;

/**
 * Trait TreeTraversalTrait
 * @package Seboettg\Forest\General
 * @property TreeNodeInterface $root
 */
trait TreeTraversalTrait
{

    /**
     * @param int $orderStrategy
     * @return ArrayListInterface
     */
    public function toArrayList(int $orderStrategy = TreeTraversalInterface::TRAVERSE_PRE_ORDER): ArrayListInterface
    {
        $result = new ArrayList();
        switch ($orderStrategy) {
            case self::TRAVERSE_IN_ORDER:
                $result = $this->root->accept(new InOrderVisitor());
                break;
            case self::TRAVERSE_PRE_ORDER:
                $result = $this->root->accept(new PreOrderVisitor());
                break;
            case self::TRAVERSE_POST_ORDER:
                $result = $this->root->accept(new PostOrderVisitor());
                break;
            case self::TRAVERSE_LEVEL_ORDER:
                $result = $this->root->accept(new LevelOrderVisitor());
        }
        return $result;
    }
}
