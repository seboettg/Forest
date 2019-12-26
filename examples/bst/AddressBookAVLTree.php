<?php
/*
 * Forest: AddressBookAVLTree.php
 * User: Sebastian Böttger <sebastian.boettger@thomascook.de>
 * created at 25.12.19, 20:44
 */

class AddressBookAVLTree extends Seboettg\Forest\AVLTree
{
    public function __construct()
    {
        parent::__construct(AddressBookEntry::class);
    }
}
