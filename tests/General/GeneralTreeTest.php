<?php
/*
 * Forest: BuilderTest.php
 * User: Sebastian Böttger <sebastian.boettger@thomascook.de>
 * created at 01.12.19, 21:54
 */

namespace Seboettg\Forest\Test\General;

use Seboettg\Forest\General\GeneralTree;
use PHPUnit\Framework\TestCase;
use Seboettg\Forest\General\IntegerItem;

class GeneralTreeTest extends TestCase
{

    public function testBuilder()
    {
        $builder = new GeneralTree(IntegerItem::class);
        /*
                1
             /     \
           2         3
                   / | \
                 4   5   6
               /  \
             7      8

        */
        $tree = $builder
            ->root(1)
                ->child(2)
                ->subTree(3)
                    ->subTree(4)
                        ->child(7)
                        ->child(8)
                    ->endSubTree()
                    ->child(5)
                    ->child(6)
                ->endSubTree()
            ->getNode();
        $this->assertEquals(3, $tree->getHeight());
        $this->assertTrue($tree->getChildren()[1]->getChildren()[0]->getChildren()[0]->getItem()->equals(new IntegerItem(7)));
    }
}
