<?php

namespace App\DataTransferObject;

class AddressFilterDto
{

    private null|string $nameOrNumber = null;
    private null|int $floor = null;
    private null|string $postcode = null;
    private null|string $lineOne = null;
    private null|string $lineTwo = null;
    private null|string $city = null;
    private null|string $county = null;
    private null|string $country = null;

    /**
     * @return string|null
     */
    public function getNameOrNumber(): ?string
    {
        return $this->nameOrNumber;
    }

    /**
     * @param string|null $nameOrNumber
     */
    public function setNameOrNumber(?string $nameOrNumber): void
    {
        $this->nameOrNumber = $nameOrNumber;
    }

    /**
     * @return int|null
     */
    public function getFloor(): ?int
    {
        return $this->floor;
    }

    /**
     * @param int|null $floor
     */
    public function setFloor(?int $floor): void
    {
        $this->floor = $floor;
    }

    /**
     * @return string|null
     */
    public function getPostcode(): ?string
    {
        return $this->postcode;
    }

    /**
     * @param string|null $postcode
     */
    public function setPostcode(?string $postcode): void
    {
        $this->postcode = $postcode;
    }

    /**
     * @return string|null
     */
    public function getLineOne(): ?string
    {
        return $this->lineOne;
    }

    /**
     * @param string|null $lineOne
     */
    public function setLineOne(?string $lineOne): void
    {
        $this->lineOne = $lineOne;
    }

    /**
     * @return string|null
     */
    public function getLineTwo(): ?string
    {
        return $this->lineTwo;
    }

    /**
     * @param string|null $lineTwo
     */
    public function setLineTwo(?string $lineTwo): void
    {
        $this->lineTwo = $lineTwo;
    }

    /**
     * @return string|null
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * @param string|null $city
     */
    public function setCity(?string $city): void
    {
        $this->city = $city;
    }

    /**
     * @return string|null
     */
    public function getCounty(): ?string
    {
        return $this->county;
    }

    /**
     * @param string|null $county
     */
    public function setCounty(?string $county): void
    {
        $this->county = $county;
    }

    /**
     * @return string|null
     */
    public function getCountry(): ?string
    {
        return $this->country;
    }

    /**
     * @param string|null $country
     */
    public function setCountry(?string $country): void
    {
        $this->country = $country;
    }


}
