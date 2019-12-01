<?php
declare(strict_types=1);
/*
 * Forest: AVLTreeTest.php
 * User: Sebastian Böttger <sebastian.boettger@thomascook.de>
 * created at 14.09.19, 17:03
 */

namespace Seboettg\Forest\Test\AVLTree;

use Seboettg\Collection\ArrayList;
use Seboettg\Collection\Collections;
use Seboettg\Collection\Comparable\Comparable;
use Seboettg\Collection\Comparable\Comparator;
use Seboettg\Forest\AVLTree\AVLNodeInterface;
use Seboettg\Forest\AVLTree\AVLTree;
use PHPUnit\Framework\TestCase;
use Seboettg\Forest\General\IntegerItem;
use Seboettg\Forest\General\StringItem;
use Seboettg\Forest\General\TreeTraversalInterface;

class AVLTreeTest extends TestCase
{

    /**
     * @dataProvider conditionsDataProvider
     * @param ArrayList $insertItems
     */
    public function testBinaryTreeCondition(ArrayList $insertItems)
    {
        $avlTree = $this->insertItemsInAvlTree($insertItems);
        $list = $avlTree->toArrayList(TreeTraversalInterface::TRAVERSE_IN_ORDER);
        $sortedList = Collections::sort($insertItems, new class extends Comparator {
            public function compare(Comparable $a, Comparable $b) {
                return $a->compareTo($b) > 0;
            }
        });
        $this->assertEquals($sortedList, $list);
    }


    /**
     * @dataProvider conditionsDataProvider
     * @param ArrayList $insertItems
     * @param $expectedHeight
     */
    public function testAvlTreeCondition(ArrayList $insertItems, $expectedHeight)
    {
        $avlTree = $this->insertItemsInAvlTree($insertItems);
        $root = $avlTree->getRootNode();
        $this->checkAvlCondition($root);
        //The height of a not self-balancing tree would be equal to the number of items in the tree
        $this->assertTrue($avlTree->toArrayList()->count() > $root->getHeight(), "tree height isn't greater than number of elements.");
        $this->assertEquals($expectedHeight, $root->getHeight());
    }

    private function checkAvlCondition(?AVLNodeInterface $node) {
        if ($node == null) { //no children
            return;
        }
        $leftHeight = !empty($node->getLeft()) ? $node->getLeft()->getHeight() : 0;
        $rightHeight = !empty($node->getRight()) ? $node->getRight()->getHeight() : 0;
        $heightDiff = abs($leftHeight - $rightHeight);
        $this->assertTrue($heightDiff <= 2);
        $this->checkAvlCondition($node->getLeft());
        $this->checkAvlCondition($node->getRight());
    }

    public function conditionsDataProvider()
    {
        $first = [
            new IntegerItem(3),
            new IntegerItem(2),
            new IntegerItem(1),
            new IntegerItem(4),
            new IntegerItem(5),
            new IntegerItem(6),
            new IntegerItem(7),
            new IntegerItem(9),
            new IntegerItem(8)
        ];

        $asc = [
            new StringItem("A"),
            new StringItem("B"),
            new StringItem("C"),
            new StringItem("D"),
            new StringItem("E"),
            new StringItem("F"),
            new StringItem("G")
        ];

        $desc = [
            new StringItem("G"),
            new StringItem("F"),
            new StringItem("E"),
            new StringItem("D"),
            new StringItem("C"),
            new StringItem("B"),
            new StringItem("A")
        ];

        $mixed = [
            new StringItem("A"),
            new StringItem("D"),
            new StringItem("F"),
            new StringItem("E"),
            new StringItem("B"),
            new StringItem("G"),
            new StringItem("C")
        ];

        $long = [
            new StringItem("A"),
            new StringItem("D"),
            new StringItem("F"),
            new StringItem("E"),
            new StringItem("B"),
            new StringItem("G"),
            new StringItem("C"),
            new StringItem("X"),
            new StringItem('Y'),
            new StringItem('Z')
        ];
        /*
                   (A)
                     \
                      (B)

                   (B)
                  /  \
               (A)    (C)

                  (B)
                 /   \
              (A)     (C)
                         \
                          (D)

                  (B)
                 /   \
              (A)     (D)
                     /   \
                  (C)     (E)

                  (D)
                /    \
             (B)     (E)
           /    \        \
         (A)   (C)       (F)

         */
        return [
            [new ArrayList(...$first), 4],
            [new ArrayList(...$desc), 3],
            [new ArrayList(...$asc), 3],
            [new ArrayList(...$mixed), 3],
            [new ArrayList(...$long), 4]
        ];
    }

    /**
     * @param ArrayList $insertItems
     * @return AVLTree
     */
    private function insertItemsInAvlTree(ArrayList $insertItems): AVLTree
    {
        $avlTree = new AVLTree();
        foreach ($insertItems as $item) {
            $avlTree->insert($item);
        }
        return $avlTree;
    }

    public function testSearch()
    {
        $long = [
            new StringItem("A"),
            new StringItem("D"),
            new StringItem("F"),
            new StringItem("E"),
            new StringItem("B"),
            new StringItem("G"),
            new StringItem("C"),
            new StringItem("X"),
            new StringItem('Y'),
            new StringItem('Z')
        ];
        $avlTree = $this->insertItemsInAvlTree(new ArrayList(...$long));
        $result = $avlTree->search(new StringItem("X"));
        $this->assertTrue($result instanceof AVLNodeInterface);
        $this->assertNotNull($result);
        $this->assertNull($avlTree->search(new StringItem("H")));

    }
}
