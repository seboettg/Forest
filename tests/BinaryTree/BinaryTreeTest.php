<?php
declare(strict_types=1);
/*
 * Trees: BinaryTreeTest.php
 * User: Sebastian Böttger <seboettg@gmail.com>
 * created at 2019-02-16, 18:19
 */

namespace Seboettg\Forest\Test\BinaryTree;

use PHPUnit\Framework\TestCase;
use Seboettg\Forest\BinaryTree\BinaryTree;
use Seboettg\Forest\General\Item;
use Seboettg\Forest\General\StringItem;

class BinaryTreeTest extends TestCase
{

    public function insertSearchDataProvider()
    {
        $insertItems = [new Item(5), new Item(3), new Item(7), new Item(12), new Item(10)];
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
        $searchItem = new Item($searchValue);
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

}
