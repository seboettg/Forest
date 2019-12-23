# Forest

"Forest" is a PHP library that contains classes to create tree data structures such as binary or AVL trees. Furthermore, typical tree traversing strategies are implemented.

## How to use Forest

You have to distinguish the purpose for using Forest. There are three different implementations: 
* General Tree: Each node can have not more than one parent. Only one node can have no parent, this node is the root of the tree. Each node can have any number of children 
* Binary Search Tree: Same as General Tree, but each node can have only two children. Inserting of children follows an order. For each inserted node the following condition applies: The associated value or label of the left node must be smaller than the associated value or label of the right node. https://en.wikipedia.org/wiki/Binary_tree
* AVL Tree: Same as Binary Search Tree, but the AVL condition must apply:  the heights of the two child subtrees of any node differ by at most one; if at any time they differ by more than one, rebalancing is done to restore this property. The AVL Tree is a self-balancing binary search tree. https://en.wikipedia.org/wiki/AVL_tree


### General tree

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
use Seboettg\Forest\General\GeneralTree;
use Seboettg\Forest\General\IntegerItem;
$tree = new GeneralTree(IntegerItem::class);
```

You can also add other Items for trees, but be aware that this item MUST implement the `Seboettg\Forest\GeneralTree\ItemInterface`.
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

### Binary Search Tree (BST)

A node of a Binary Tree has always 2 or less children. Unlike the General Tree, the Binary Search Tree (BST) itself decides where the nodes are added, so that always the following conditions met: for each node, the left child node is smaller and the right is greater.

Assuming you want add the following values to a BST: d g b f a c e h. This will result in the following tree structure:

```
          d
      /       \
    b           g
  /  \         / \
 a    c       f   h 
             /
            e
```

As you can easily see, there is an inherent sorting by the BST condition. This predestines the BST as a data structure for fast searches. In the best case, the runtime is only log(n).

```php
use Seboettg\Forest\BinaryTree;
$bst = new BinaryTree();
foreach (['d', 'g', 'b', 'f', 'a', 'c', 'e', 'h'] as $char) {
    $bst->insert($char);
}
```

If you want to get the tree contents as list and you choose In-order traversal strategy you will get a sorted list, since in in-order strategy the left subtree is visited first, then the root and later the right subtree.

```php
use Seboettg\Forest\General\TreeTraversalInterface;
$list = $bst->toArrayList(TreeTraversalInterface::TRAVERSE_IN_ORDER);
// result is ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h']
```

