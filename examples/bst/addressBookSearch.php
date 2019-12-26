#!/usr/bin/php
<?php
/*
 * Forest: binarySearchTree.php
 * User: Sebastian Böttger <sebastian.boettger@thomascook.de>
 * created at 24.12.19, 14:53
 */
require_once "../../vendor/autoload.php";
require_once "AddressBookBinaryTree.php";
require_once "AddressBookAVLTree.php";
require_once "AddressBookEntry.php";

function generatorPhoneEntries()
{
    $handle = fopen("entries.csv", "r+");
    while (($item = fgetcsv($handle, 1000, ";")) !== false) {
        yield new AddressBookEntry($item[1], $item[0], $item[2], trim($item[3]));
    }
}

if ($argc < 4) {
    echo "Please run:\nphp addressBookSearch.php LastName FirstName (Binary|AVL)\n";
    exit();
}

if ($argv[3] === "AVL") {
    $dataStructure = "AVLTree";
    $addressBook = new AddressBookAvlTree();
} else if ($argv[3] === "Binary") {
    $dataStructure = "BinaryTree";
    $addressBook = new AddressBookBinaryTree();
} else {
    echo "Invalid data structure. Use either 'Binary' or 'AVL'!\n";
}

foreach (generatorPhoneEntries() as $addressBookEntry) {
    $addressBook->insert($addressBookEntry);
}

$timeBefore = microtime();
$result = $addressBook->search(new AddressBookEntry($argv[1], $argv[2]));
$timeAfter = microtime();

$time = $timeAfter - $timeBefore; // runtime of search

if (null === $result) {
    echo "No entry found\n";
} else {
    $searchResultItem = $result->getItem();
    echo $searchResultItem->getLastName() . ", " . $searchResultItem->getFirstName() . "\n";
    echo $searchResultItem->getAddress() . "\n";
    echo "Phone No.: " . $searchResultItem->getPhoneNumber() . "\n";
}
echo "Time to search with $dataStructure: " . sprintf("%1.2E", $time) . "\n";
