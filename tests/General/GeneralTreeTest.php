<?php

namespace Seboettg\Forest\Test\General;

use ErrorException;
use \InvalidArgumentException;
use Seboettg\Collection\ArrayList;
use Seboettg\Forest\General\GeneralTree;
use PHPUnit\Framework\TestCase;
use Seboettg\Forest\General\IntegerItem;
use Seboettg\Forest\General\StringItem;
use Seboettg\Forest\General\TreeTraversalInterface;

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

    public function testBuilder2()
    {
        $builder = new GeneralTree(StringItem::class);
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
            ->root(new StringItem("a"))
                ->child(new StringItem("b"))
                ->subTree("c")
                    ->subTree("d")
                        ->child("g")
                        ->child("h")
                    ->endSubTree()
                    ->child("e")
                    ->child("f")
                ->endSubTree()
                ->getNode();
        $this->assertEquals(3, $tree->getHeight());
        /** @var ArrayList $list */
        $list = $builder->toArrayList(TreeTraversalInterface::TRAVERSE_LEVEL_ORDER);
        $array = $list->map(function(StringItem $item) {
            return $item->getValue();
        })->toArray();
        $this->assertEquals(["a", "b", "c", "d", "e", "f", "g", "h"], $array);

    }

    /**
     * @throws ErrorException
     *
     */
    public function testInOrderVisitor()
    {
        $builder = new GeneralTree(IntegerItem::class);
        $tree = $builder
            ->root(1)
                ->child(2)
                ->subTree(3)
                    ->child(4)
                    ->child(5)
                    ->child(6)
                ->endSubTree();
        $this->expectException(InvalidArgumentException::class);
        $tree->toArrayList(TreeTraversalInterface::TRAVERSE_IN_ORDER);
    }

    public function testCount()
    {
        $builder = new GeneralTree(IntegerItem::class);
        $builder
            ->root(1)
            ->child(2)
            ->subTree(3)
            ->child(4)
            ->child(5)
            ->child(6)
            ->endSubTree();
        $this->assertEquals(6, $builder->count());
    }
}
