<?php
declare(strict_types=1);

namespace Seboettg\Forest\Test;

use Seboettg\Collection\ArrayList;
use Seboettg\Forest\AVLTree;
use Seboettg\Forest\BinaryTree\BinaryNodeInterface;
use Seboettg\Forest\General\TreeTraversalInterface;
use Seboettg\Forest\Item\IntegerItem;
use Seboettg\Forest\Item\StringItem;

class AVLTreeTest extends BinaryTreeTest
{

    /**
     * @dataProvider conditionsDataProvider
     * @param ArrayList $insertItems
     * @param $expectedHeight
     */
    public function testAvlTreeCondition(ArrayList $insertItems, $expectedHeight)
    {
        $avlTree = $this->insertItems($insertItems, new AVLTree());
        $root = $avlTree->getRootNode();
        $this->checkAvlCondition($root);
        //The height of a not self-balancing tree would be equal to the number of items in the tree
        $this->assertTrue($avlTree->toArrayList()->count() > $root->getHeight(), "tree height isn't greater than number of elements.");
        $this->assertEquals($expectedHeight, $root->getHeight());
    }

    private function checkAvlCondition(?BinaryNodeInterface $node) {
        if ($node == null) { //no children
            return;
        }
        $leftHeight = !empty($node->getLeft()) ? $node->getLeft()->getHeight() : 0;
        $rightHeight = !empty($node->getRight()) ? $node->getRight()->getHeight() : 0;
        $heightDiff = abs($leftHeight - $rightHeight);
        $this->assertTrue($heightDiff < 2);
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

        $long2 = [
            new StringItem('Z'),
            new StringItem('Y'),
            new StringItem("X"),
            new StringItem("C"),
            new StringItem("G"),
            new StringItem("B"),
            new StringItem("E"),
            new StringItem("F"),
            new StringItem("D"),
            new StringItem("A"),
        ];
        return [
            [new ArrayList(...$first), 3],
            [new ArrayList(...$desc), 3],
            [new ArrayList(...$asc), 3],
            [new ArrayList(...$mixed), 3],
            [new ArrayList(...$long), 4],
            [new ArrayList(...$long2), 3]
        ];
    }

    public function testSearchAvl()
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
        $avlTree = $this->insertItems(new ArrayList(...$long), new AVLTree());
        $result = $avlTree->search(new StringItem("X"));
        $this->assertTrue($result instanceof BinaryNodeInterface);
        $this->assertNotNull($result);
        $this->assertNull($avlTree->search(new StringItem("H")));

    }

    /**
     * @dataProvider removeDataProvider
     * @param string $className
     * @param array $insert
     * @param array $remove
     * @param array $expectedResults
     */
    public function testRemove(string $className, array $insert, array $remove, array $expectedResults)
    {

        $insertItems = array_map(self::mapItem($className), $insert);

        $avlTree = new AVLTree($className);
        foreach ($insertItems as $item) {
            $avlTree->insert($item);
        }

        $list = $avlTree->toArrayList(TreeTraversalInterface::TRAVERSE_IN_ORDER);
        $sortedInsert = $insert;
        sort($sortedInsert);
        $this->assertEquals(array_map(self::mapItem($className), $sortedInsert), $list->toArray());

        foreach ($remove as $rmValue) {
            $avlTree->remove($rmValue); //remove
            $this->checkAvlCondition($avlTree->getRootNode());
        }

        $list = $avlTree->toArrayList(TreeTraversalInterface::TRAVERSE_IN_ORDER); //to list
        $this->assertEquals(array_map(self::mapItem($className), $expectedResults), $list->toArray()); //compare with expected value
    }

    public function removeDataProvider()
    {
        /*
                       G
                    /     \
                 C           Y
               /   \       /   \
             B       E    X     Z
            /       / \
           A       D   F

        */

        return [
            "remove D" => [
                StringItem::class,
                ['Z', 'Y', 'X', 'C', 'G', 'B', 'E', 'F', 'D', 'A'],
                ['D'],
                ['A', 'B', 'C', 'E', 'F', 'G', 'X', 'Y', 'Z']
            ],
            "remove F" => [
                StringItem::class,
                ['Z', 'Y', 'X', 'C', 'G', 'B', 'E', 'F', 'D', 'A'],
                ['F'],
                ['A', 'B', 'C', 'D', 'E', 'G', 'X', 'Y', 'Z']
            ],
            "remove C" => [
                StringItem::class,
                ['Z', 'Y', 'X', 'C', 'G', 'B', 'E', 'F', 'D', 'A'],
                ['C'],
                ['A', 'B', 'D', 'E', 'F', 'G', 'X', 'Y', 'Z']
            ],
            "remove G" => [
                StringItem::class,
                ['Z', 'Y', 'X', 'C', 'G', 'B', 'E', 'F', 'D', 'A'],
                ['G'],
                ['A', 'B', 'C', 'D', 'E', 'F', 'X', 'Y', 'Z']
            ],
            "remove J K L" => [
                StringItem::class,
                ['L', 'M', 'N', 'K', 'I', 'J', 'H', 'T', 'V', 'W', 'U', 'O', 'P', 'Q', 'R', 'S', 'X', 'Y', 'Z', 'C', 'B', 'F', 'E', 'A', 'D', 'G'],
                ['J', 'K', 'L'],
                ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z']
            ],
            "remove 49 50 51" => [
                IntegerItem::class,
                range(0, 99),
                [49, 50, 51],
                array_merge(range(0, 48), range(52, 99))
            ],
            "remove 25 50 75" => [
                IntegerItem::class,
                range(0, 99),
                [25, 50, 75],
                array_merge(range(0, 24), range(26, 49), range(51, 74), range(76, 99))
            ]
        ];

    }
}
