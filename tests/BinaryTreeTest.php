<?php
declare(strict_types=1);

namespace Seboettg\Forest\Test;

use PHPUnit\Framework\TestCase;
use Seboettg\Collection\ArrayList;
use Seboettg\Collection\Collections;
use Seboettg\Collection\Comparable\Comparable;
use Seboettg\Collection\Comparable\Comparator;
use Seboettg\Forest\AVLTree;
use Seboettg\Forest\BinaryTree;
use Seboettg\Forest\General\TreeTraversalInterface;
use Seboettg\Forest\Item\IntegerItem;
use Seboettg\Forest\Item\StringItem;

class BinaryTreeTest extends TestCase
{


    /**
     * @param ArrayList $insertItems
     * @param BinaryTree\BinaryTreeInterface $tree
     * @return AVLTree
     */
    protected function insertItems(ArrayList $insertItems, BinaryTree\BinaryTreeInterface $tree): BinaryTree\BinaryTreeInterface
    {
        foreach ($insertItems as $item) {
            $tree->insert($item);
        }
        return $tree;
    }

    /**
     * @dataProvider conditionsDataProvider
     * @param ArrayList $insertItems
     * @param BinaryTree\BinaryTreeInterface $tree
     */
    public function binaryTreeCondition(ArrayList $insertItems, BinaryTree\BinaryTreeInterface $tree)
    {
        $tree = $this->insertItems($insertItems, $tree);
        $list = $tree->toArrayList(TreeTraversalInterface::TRAVERSE_IN_ORDER);
        $sortedList = Collections::sort($insertItems, new class extends Comparator {
            public function compare(Comparable $a, Comparable $b): int {
                return $a->compareTo($b) > 0 ? 1 : -1;
            }
        });
        $this->assertEquals($sortedList, $list);
    }

    public function insertSearchDataProvider()
    {
        $insertItems = [new IntegerItem(5), new IntegerItem(3), new IntegerItem(7), new IntegerItem(12), new IntegerItem(10)];
        return [
            [$insertItems, 5, 10, true],
            [$insertItems, 5, 11, false]
        ];
    }

    /**
     * @dataProvider insertSearchDataProvider
     * @param array $data
     * @param int $expectedCount
     * @param int $searchValue
     * @param bool $searchValueExist
     */
    public function testInsert(array $data, int $expectedCount, int $searchValue, bool $searchValueExist)
    {
        $binaryTree = $this->fillBinaryTree($data);
        $this->assertEquals($expectedCount, $binaryTree->count());
    }

    /**
     * @dataProvider insertSearchDataProvider
     * @param array $data
     * @param int $expectedCount
     * @param int $searchValue
     * @param bool $searchValueExist
     */
    public function testSearch(array $data, int $expectedCount, int $searchValue, bool $searchValueExist)
    {
        $binaryTree = $this->fillBinaryTree($data);
        $searchItem = new IntegerItem($searchValue);
        $actualNode = $binaryTree->search($searchItem);
        if ($searchValueExist) {
            $this->assertNotNull($actualNode);
            $this->assertEquals($actualNode->getItem()->getValue(), $searchItem->getValue());
        } else {
            $this->assertNull($actualNode);
        }
    }

    public function toArrayListDataProvider()
    {
        /*
         *           (D)
         *         /     \
         *      (B)       (F)
         *     /   \     /   \
         *   (A)   (C) (E)   (G)
         */
        $insertItems = [
            new StringItem("D"),
            new StringItem("F"),
            new StringItem("E"),
            new StringItem("B"),
            new StringItem("G"),
            new StringItem("C"),
            new StringItem("A")
        ];

        /*
         *           (A)
         *         /     \
         *               (D)
         *             /     \
         *          (B)       (F)
         *         /   \     /   \
         *             (C) (E)   (G)
         */
        $insertItems2 = [
            new StringItem("A"),
            new StringItem("D"),
            new StringItem("F"),
            new StringItem("E"),
            new StringItem("B"),
            new StringItem("G"),
            new StringItem("C")
        ];
        return [
            [$insertItems, BinaryTree::TRAVERSE_IN_ORDER, ['A', 'B', 'C', 'D', 'E', 'F', 'G']],
            [$insertItems, BinaryTree::TRAVERSE_PRE_ORDER, ['D', 'B', 'A', 'C', 'F', 'E', 'G']],
            [$insertItems, BinaryTree::TRAVERSE_POST_ORDER, ['A', 'C', 'B', 'E', 'G', 'F', 'D']],
            [$insertItems, BinaryTree::TRAVERSE_LEVEL_ORDER, ['D', 'B', 'F', 'A', 'C', 'E', 'G']],
            [$insertItems2, BinaryTree::TRAVERSE_IN_ORDER, ['A', 'B', 'C', 'D', 'E', 'F', 'G']]
        ];
    }

    /**
     * @dataProvider toArrayListDataProvider
     * @param $insertItems
     * @param $orderStrategy
     * @param $expectedOrder
     */
    public function testToArrayList($insertItems, $orderStrategy, $expectedOrder)
    {
        $binaryTree = $this->fillBinaryTree($insertItems);
        $stringItemList = $binaryTree->toArrayList($orderStrategy);
        for($i = 0; $i < $stringItemList->count(); ++$i) {
            /** @var StringItem $stringItem */
            $stringItem = $stringItemList->get($i);
            $this->assertEquals($stringItem, $expectedOrder[$i]);
        }
    }

    /**
     * @param array $data
     * @return BinaryTree
     */
    private function fillBinaryTree(array $data): BinaryTree
    {
        $binaryTree = new BinaryTree();
        foreach ($data as $item) {
            $binaryTree->insert($item);
        }
        return $binaryTree;
    }

    /**
     * @dataProvider removeDataProvider
     */
    public function testRemove(array $insert, array $remove, array $expectedResults)
    {

        $insertItems = array_map(self::mapStringItem(), $insert);

        $binaryTree = new BinaryTree(StringItem::class);
        foreach ($insertItems as $item) {
            $binaryTree->insert($item);
        }

        $list = $binaryTree->toArrayList(TreeTraversalInterface::TRAVERSE_IN_ORDER);
        $sortedInsert = $insert;
        sort($sortedInsert);
        $this->assertEquals(array_map(self::mapStringItem(), $sortedInsert), $list->toArray());

        foreach ($remove as $rmValue) {
            $binaryTree->remove($rmValue); //remove
        }

        $list = $binaryTree->toArrayList(TreeTraversalInterface::TRAVERSE_IN_ORDER); //to list
        $this->assertEquals(array_map(self::mapStringItem(), $expectedResults), $list->toArray()); //compare with expected value
    }

    public function removeDataProvider()
    {
        return [
            [
                /*
                 *           (A)
                 *         /     \
                 *               (D)
                 *             /     \
                 *          (B)       (F)
                 *         /   \     /   \
                 *             (C) (E)   (G)
                 */
                ['A', 'D', 'F', 'E', 'B', 'G', 'C'],
                ['F'],
                ['A', 'B', 'C', 'D', 'E', 'G']
            ],
            [
                /*
                 *           (A)
                 *         /     \
                 *               (D)
                 *             /     \
                 *          (B)       (F)
                 *         /   \     /   \
                 *             (C) (E)   (G)
                 */
                ['A', 'D', 'F', 'E', 'B', 'G', 'C'],
                ['A'],
                ['B', 'C', 'D', 'E', 'F', 'G']
            ],
            [
                ['Z', 'Y', 'X', 'C', 'G', 'B', 'E', 'F', 'D', 'A'],
                ['D'],
                ['A', 'B', 'C', 'E', 'F', 'G', 'X', 'Y', 'Z']
            ],
            [
                ['Z', 'Y', 'X', 'C', 'G', 'B', 'E', 'F', 'D', 'A'],
                ['C'],
                ['A', 'B', 'D', 'E', 'F', 'G', 'X', 'Y', 'Z']
            ],
            [
                ['Z', 'Y', 'X', 'C', 'G', 'B', 'E', 'F', 'D', 'A'],
                ['G'],
                ['A', 'B', 'C', 'D', 'E', 'F', 'X', 'Y', 'Z']
            ]
        ];
    }

    protected static function mapStringItem()
    {
        return function($value) {
            return new StringItem($value);
        };
    }
}
