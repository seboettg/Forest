<?php
/*
 * Forest: binarySearchTree.php
 * User: Sebastian Böttger <sebastian.boettger@thomascook.de>
 * created at 24.12.19, 14:53
 */
require_once "../../vendor/autoload.php";
require_once "PhoneBook.php";
require_once "PhoneBookEntry.php";

function generatorPhoneEntries()
{
    $handle = fopen("entries.csv", "r+");
    while (($item = fgetcsv($handle, 1000, ";")) !== false) {
        yield new PhoneBookEntry($item[1], $item[0], $item[2], trim($item[3]));
    }
}

if ($argc < 3) {
    echo "Please run:\nphp searchPhoneBook.php LastName FirstName\n";
    exit();
}

$phoneBook = new PhoneBook(PhoneBookEntry::class);
foreach (generatorPhoneEntries() as $phoneBookEntry) {
    $phoneBook->insert($phoneBookEntry);
}
$result = $phoneBook->search(new PhoneBookEntry($argv[1], $argv[2]));
if (null === $result) {
    echo "No entry found\n";
} else {
    $searchResultItem = $result->getItem();
    echo $searchResultItem->getLastName() . ", " . $searchResultItem->getFirstName() . "\n";
    echo $searchResultItem->getAddress() . "\n";
    echo "Phone No.: " . $searchResultItem->getPhoneNumber() . "\n";
}
