<?php
/*
 * Forest: PhoneBook.php
 * User: Sebastian Böttger <sebastian.boettger@thomascook.de>
 * created at 24.12.19, 15:02
 */

class AddressBookBinaryTree extends Seboettg\Forest\BinaryTree
{
    public function __construct()
    {
        parent::__construct(AddressBookEntry::class);
    }
}
