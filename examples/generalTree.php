<?php
declare(strict_types=1);
/*
* Copyright (C) 2019 Sebastian Böttger <seboettg@gmail.com>
* You may use, distribute and modify this code under the
* terms of the MIT license.
*
* You should have received a copy of the MIT license with
* this file. If not, please visit: https://opensource.org/licenses/mit-license.php
*/

require "../vendor/autoload.php";

use Seboettg\Forest\General\GeneralTree;
use Seboettg\Forest\General\IntegerItem;
use Seboettg\Forest\General\TreeTraversalInterface;

$builder = new GeneralTree(IntegerItem::class);

$builder
    ->root(1)
        ->child(2)
        ->subTree(3)
            ->subTree(4)
                ->child(7)
                ->child(8)
            ->endSubTree()
            ->child(5)
            ->child(6)
        ->endSubTree();
echo $builder->count() . " items added to tree\n";

$rootNode = $builder->getRoot();

if ($rootNode->isRoot()) {
    echo "root node\n";
}
if (!$rootNode->isLeaf()) {
    echo "no leaf node\n";
}

echo "2. child of root has a height of " . $rootNode->getChildren()[1]->getHeight() . "\n";

echo "Values of level 3 nodes: ";
foreach ($rootNode->getChildren() as $lev1) {
    if (count($lev1->getChildren()) > 0) {
        foreach ($lev1->getChildren() as $lev2) {
            if (count($lev2->getChildren()) > 0) {
                foreach ($lev2->getChildren() as $lev3) {
                    echo $lev3->getItem()->getValue() . " ";
                }
            }
        }
    }
}
echo "\n";


$list = $builder->toArrayList(TreeTraversalInterface::TRAVERSE_LEVEL_ORDER);

/** @var IntegerItem $item */
foreach ($list as $item) {
    echo $item->getValue();
}
echo "\n";
