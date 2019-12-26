<?php

namespace Seboettg\Forest\Test\General;

use Seboettg\Forest\General\TreeNode;
use PHPUnit\Framework\TestCase;
use Seboettg\Forest\Item\IntegerItem;

class TreeNodeTest extends TestCase
{

    /**
     *
     */
    public function testBuildTree()
    {
        $root = new TreeNode(new IntegerItem(5));
        $this->assertEquals(0, $root->getHeight());
        foreach ([6,7,8,9] as $item) {
            $root->addChild(new TreeNode(new IntegerItem($item)));
        }
        $this->assertTrue($root->isRoot());
        foreach ($root->getChildren() as $child) {
            $this->assertTrue($child->isChild());
            $this->assertTrue($child->isLeaf());
            $this->assertEquals(0, $child->getHeight());
            $this->assertEquals(1, $child->getLevel());
        }
        $this->assertEquals(1, $root->getHeight());
        $child1 = $root->getChildren()[0];
        $this->assertEquals($child1->getParent(), $root);
    }
}
