<?php
/*
 * Forest: AVLNodeInterface.php
 * User: Sebastian Böttger <sebastian.boettger@thomascook.de>
 * created at 14.09.19, 16:07
 */

namespace Seboettg\Forest\AVLTree;


use Seboettg\Forest\BinaryTree\BinaryNodeInterface;

interface AVLNodeInterface extends BinaryNodeInterface
{
    public function getBalance(): int;
    public function setBalance(int $balance): void;
}
