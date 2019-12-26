<?php

namespace Seboettg\Forest\Test;

use ErrorException;
use \InvalidArgumentException;
use Seboettg\Collection\ArrayList;
use PHPUnit\Framework\TestCase;
use Seboettg\Forest\General\TreeTraversalInterface;
use Seboettg\Forest\GeneralTree;
use Seboettg\Forest\Item\IntegerItem;
use Seboettg\Forest\Item\StringItem;

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
        $this->assertEquals($tree->getChildren()[1]->getChildren()[0]->getChildren()[0]->getItem(), new IntegerItem(7));
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
