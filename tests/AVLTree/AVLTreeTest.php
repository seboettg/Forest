<?php
/*
 * Forest: AVLTreeTest.php
 * User: Sebastian Böttger <sebastian.boettger@thomascook.de>
 * created at 14.09.19, 17:03
 */

namespace Seboettg\Forest\Test\AVLTree;

use Seboettg\Forest\AVLTree\AVLTree;
use PHPUnit\Framework\TestCase;
use Seboettg\Forest\General\TreeInterface;
use Seboettg\Forest\Test\Helper\StringItem;

class AVLTreeTest extends TestCase
{


    public function insertDataProvider()
    {
        $insertItems = [
            new StringItem("A"),
            new StringItem("D"),
            new StringItem("F"),
            new StringItem("E"),
            new StringItem("B"),
            new StringItem("G"),
            new StringItem("C")
        ];
        return [
            [$insertItems]
        ];
    }

    /**
     * @dataProvider insertDataProvider
     * @param array $insertItems
     */
    public function testInsert(array $insertItems)
    {
        $avlTree = new AVLTree();
        foreach ($insertItems as $item) {
            $avlTree->insert($item);
        }
        $list = $avlTree->toArrayList(TreeInterface::TRAVERSE_IN_ORDER);
    }

}
