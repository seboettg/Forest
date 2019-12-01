# Forest

"Forest" is a PHP library that contains classes to create tree data structures such as binary or AVL trees. Furthermore, typical tree traversing strategies are implemented.

## How to use Forest

You have to distinguish the purpose for using Forest. There are three different implementations: 
* General Tree: Each node can have not more than one parent. Only one node can have no parent, this node is the root of the tree. Each node can have any number of children 
* Binary Tree: Same as General Tree, but each node can have only two children. Inserting of children follows an order. For each inserted node the following condition applies: The associated value or label of the left node must be smaller than the associated value or label of the right node. https://en.wikipedia.org/wiki/Binary_tree
* AVL Tree: Same as Binary Tree, but the AVL condition must apply:  the heights of the two child subtrees of any node differ by at most one; if at any time they differ by more than one, rebalancing is done to restore this property. The AVL Tree is a self-balancing binary search tree. https://en.wikipedia.org/wiki/AVL_tree


### General tree

