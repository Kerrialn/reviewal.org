<?php

namespace App\Entity;

use App\Repository\AddressRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Mapping as ORM;
use Locale;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: AddressRepository::class)]
class Address
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\CustomIdGenerator(UuidGenerator::class)]
    private Uuid $id;

    #[ORM\Column(length: 255)]
    private ?string $nameOrNumber = null;

    #[ORM\Column(length: 255)]
    private ?string $postcode = null;

    #[ORM\Column(length: 255)]
    private ?string $lineOne = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $lineTwo = null;

    #[ORM\Column(length: 255)]
    private ?string $city = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $county = null;

    #[ORM\Column(length: 3)]
    private ?string $country = null;

    #[ORM\Column]
    private DateTimeImmutable $createdAt;

    #[ORM\OneToMany(mappedBy: 'address', targetEntity: Review::class)]
    private Collection $reviews;

    #[ORM\OneToMany(mappedBy: 'address', targetEntity: UserAddress::class)]
    private Collection $userAddresses;

    #[ORM\Column]
    private ?int $floor = null;

    public function __construct()
    {
        $this->reviews = new ArrayCollection();
        $this->userAddresses = new ArrayCollection();
        $this->createdAt = new DateTimeImmutable();
    }

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getNameOrNumber(): ?string
    {
        return $this->nameOrNumber;
    }

    public function setNameOrNumber(string $nameOrNumber): self
    {
        $this->nameOrNumber = $nameOrNumber;

        return $this;
    }

    public function getPostcode(): ?string
    {
        return $this->postcode;
    }

    public function setPostcode(string $postcode): self
    {
        $this->postcode = $postcode;

        return $this;
    }

    public function getLineOne(): ?string
    {
        return $this->lineOne;
    }

    public function setLineOne(string $lineOne): self
    {
        $this->lineOne = $lineOne;

        return $this;
    }

    public function getLineTwo(): ?string
    {
        return $this->lineTwo;
    }

    public function setLineTwo(?string $lineTwo): self
    {
        $this->lineTwo = $lineTwo;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getCounty(): ?string
    {
        return $this->county;
    }

    public function setCounty(?string $county): self
    {
        $this->county = $county;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return Collection<int, Review>
     */
    public function getReviews(): Collection
    {
        return $this->reviews;
    }

    public function addReview(Review $review): self
    {
        if (!$this->reviews->contains($review)) {
            $this->reviews->add($review);
            $review->setAddress($this);
        }

        return $this;
    }

    public function removeReview(Review $review): self
    {
        if ($this->reviews->removeElement($review)) {
            // set the owning side to null (unless already changed)
            if ($review->getAddress() === $this) {
                $review->setAddress(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, UserAddress>
     */
    public function getUserAddresses(): Collection
    {
        return $this->userAddresses;
    }

    public function addUserAddress(UserAddress $userAddress): self
    {
        if (!$this->userAddresses->contains($userAddress)) {
            $this->userAddresses->add($userAddress);
            $userAddress->setAddress($this);
        }

        return $this;
    }

    public function removeUserAddress(UserAddress $userAddress): self
    {
        if ($this->userAddresses->removeElement($userAddress)) {
            // set the owning side to null (unless already changed)
            if ($userAddress->getAddress() === $this) {
                $userAddress->setAddress(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        $lineTwo = $this->getLineTwo() !== null ? $this->getLineTwo() . ',' : null;
        return "{$this->getNameOrNumber()}, floor {$this->getFloor()},  {$this->getLineOne()}, $lineTwo {$this->getPostcode()}, {$this->getCounty()}, {$this->getCity()}, {$this->getCountry()}";
    }

    public function getFloor(): ?int
    {
        return $this->floor;
    }

    public function setFloor(int $floor): self
    {
        $this->floor = $floor;

        return $this;
    }

    public function getMostRecentReviewAt(): null|DateTimeImmutable
    {
        $criteria = Criteria::create()
            ->orderBy(['createdAt' => 'DESC'])
            ->setMaxResults(1);

        $review = $this->getReviews()->matching($criteria)->first();
        return $review ? $review->getCreatedAt() : null;
    }

}
