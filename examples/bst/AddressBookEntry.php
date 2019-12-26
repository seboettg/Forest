<?php
/*
 * Forest: PhoneBookEntry.php
 * User: Sebastian Böttger <sebastian.boettger@thomascook.de>
 * created at 24.12.19, 14:57
 */

use Seboettg\Collection\Comparable\Comparable;
use Seboettg\Forest\Item\ItemInterface;

class AddressBookEntry implements ItemInterface
{

    /**
     * @var string
     */
    protected $firstName;

    /**
     * @var string
     */
    protected $lastName;

    /**
     * @var string
     */
    protected $address;

    /**
     * @var string
     */
    protected $phoneNumber;

    public function __construct(string $lastName, string $firstName, ?string $address = null, ?string $phoneNumber = null)
    {
        $this->lastName = $lastName;
        $this->firstName = $firstName;
        $this->address = $address;
        $this->phoneNumber = $phoneNumber;
    }

    public function getCompareValue()
    {
        return $this->lastName . "," . $this->firstName;
    }

    /**
     * @param Comparable|AddressBookEntry $b
     * @return int
     */
    public function compareTo(Comparable $b): int
    {
        return strcasecmp($this->getCompareValue(), $b->getCompareValue());
    }

    /**
     * @param ItemInterface|AddressBookEntry $item
     * @return bool
     */
    public function equals(ItemInterface $item): bool
    {
        return $this->compareTo($item) === 0;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @return string
     */
    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }

    /**
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }

}
