# Forest

[![PHP](https://img.shields.io/badge/PHP-%3E=7.1-green.svg?style=flat)](http://docs.php.net/manual/en/migration71.new-features.php)
[![Total Downloads](https://poser.pugx.org/seboettg/forest/downloads)](https://packagist.org/packages/seboettg/forest/stats) 
[![License](https://img.shields.io/badge/license-MIT-blue.svg?style=flat-square)](https://github.com/seboettg/forest/blob/master/LICENSE)
[![Build Status](https://scrutinizer-ci.com/g/seboettg/Forest/badges/build.png?b=master)](https://scrutinizer-ci.com/g/seboettg/Forest/build-status/master)
[![Code Coverage](https://scrutinizer-ci.com/g/seboettg/Forest/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/seboettg/Forest/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/seboettg/Forest/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/seboettg/Forest/?branch=master)
[![Code Intelligence Status](https://scrutinizer-ci.com/g/seboettg/Forest/badges/code-intelligence.svg?b=master)](https://scrutinizer-ci.com/code-intelligence)

"Forest" is a PHP library that contains classes to create tree data structures such as general trees or Binary Search Trees. Furthermore, typical tree traversing strategies are implemented.

## How to use Forest

You have to distinguish the purpose for using Forest. There are three different implementations: 
* [General Tree](#general-tree)
* [Binary Tree](#binary-tree)
* [AVL Tree](#avl-tree)

### General Tree
A general tree has the following characterics: Each node can have not more than one parent. Only one node can have no parent, this node is the root of the tree. Each node can have any number of children 

Assuming you want to create a tree with the following structure:
```
                1
             /     \
           2         3
                   / | \
                 4   5   6
               /  \
             7      8
```

First, you have to create an instance of `GeneralTree`. Pass the type of the items you want to add in this tree:

```php
use Seboettg\Forest\GeneralTree;
use Seboettg\Forest\Item\IntegerItem;
$tree = new GeneralTree(IntegerItem::class);
```

You can also add other Items for trees, but be aware that this item MUST implement the `Seboettg\Forest\Item\ItemInterface`.
Now you can add the items. The very first element must be added with `root()` 

```php
$tree
    ->root(new IntegerItem(1)) // add item objects (of type as defined in the constructor)
        ->child(2) // or simple integers (instance of IntegerItem will created automatically)  
        ->subTree(new IntegerItem(3))
            ->subTree(new IntegerItem(4))
                ->child(new IntegerItem(7))
                ->child(new IntegerItem(8))
            ->endSubTree()
            ->child(new IntegerItem(5))
            ->child(new IntegerItem(6))
        ->endSubTree();
```

To get the tree root you can do this: `$root = $builder->getRoot();`.

More examples you will find in `/examples/generalTree.php`.

### Binary Tree

Each node of a Binary Tree can have only two children. Inserting of children follows an order. For each inserted node the following condition applies: The associated value or label of the left node must be smaller than the associated value or label of the right node. https://en.wikipedia.org/wiki/Binary_tree

As mentioned a node of a Binary Tree has always two or less children. Unlike the General Tree, the Binary Tree itself decides where the nodes are added, so that the binary node condition met.

#### Sorting with Binary Trees

Assuming you want add the following values to a Binary Tree: d g b f a c e h. This will result in the following tree structure:

```
          d
      /       \
    b           g
  /  \         / \
 a    c       f   h 
             /
            e
```

If you want to get the tree contents as list and you choose In-order traversal strategy you will get a sorted list, since in in-order strategy the left subtree is visited first, then the root and later the right subtree.

```php
use Seboettg\Forest\BinaryTree;
use Seboettg\Forest\General\TreeTraversalInterface;
use Seboettg\Forest\Item\StringItem;

$bst = new BinaryTree(StringItem::class);
foreach (['d', 'g', 'b', 'f', 'a', 'c', 'e', 'h'] as $char) {
    $bst->insert($char);
}

$list = $bst->toArrayList(TreeTraversalInterface::TRAVERSE_IN_ORDER);
// result is ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h']
```

#### Searching: Using Binary Trees as Search Trees ####

As you can easily see, there is an inherent sorting by the Binary Tree condition. This predestines the this data structure for searching scenarios. Is the tree balanced the worst-case runtime is only O(log n).

```php
$result = $bst->search(new StringItem("e"));
echo $result->getItem();
```

But a simple Binary Tree can become degenerate. Assuming you add all nodes in a pre-sorted order:
```php
foreach (['a', 'b', 'c', 'd', 'e'] as $char) {
    $bst->insert($char);
}
```
Due to the binary tree condition, the tree now degenerates. Each node will be appended as a right child node, then the tree is nothing else than a linked list.

```
    a
   / \
      b
     / \
        c
       / \
          d
         / \
            e
```
If you want to use the binary tree for searching, this may have huge impact of the runtime: In worst case the runtime is O(n). 

To prevent this behavior, you can use the AVL Tree.

### AVL Tree

The AVL Tree is self-balancing binary search tree. It is actual the same as a Binary Tree, but the AVL condition must apply: the heights of the two child subtrees of any node differ by at most one; if at any time they differ by more than one, rebalancing is done to restore this property. 

This condition ensures that an AVL Tree cannot degenerate. Therefore it is particularly suitable for searching. To meet this condition, there is a special rebalancing algorithm for modifying operations invented by Georgy Adelson-Velsky and Evgenii Landis. More information about the rebalancing algorithm you will find on [Wikipedia](https://en.wikipedia.org/wiki/AVL_tree#Rebalancing).
  
```php
use Seboettg\Forest\AVLTree;
use Seboettg\Forest\Item\StringItem;
$avl = new AVLTree(StringItem::class);
foreach (['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h'] as $char) {
    $avl->insert($char);
}
```
The result is:
```
            d
          /   \
        b       f
       / \     / \
      a   c   e   g
                   \
                    h
```

### An Example of Binary Search Trees

A possible example is an [address book as you can find it in the examples folder](examples/bst/AddressBook.md). 
