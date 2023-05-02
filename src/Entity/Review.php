<?php

namespace App\Entity;

use App\Repository\ReviewRepository;
use DateTimeImmutable;
use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: ReviewRepository::class)]
class Review
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\CustomIdGenerator(UuidGenerator::class)]
    private Uuid $id;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column]
    private DateTimeImmutable $createdAt;

    #[ORM\Column]
    private DateTimeImmutable $updatedAt;

    #[ORM\ManyToOne(inversedBy: 'reviews')]
    private ?User $owner = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 5, scale: 3)]
    private null|string $generalRating = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 5, scale: 3)]
    private null|string $buildingRating = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 5, scale: 3)]
    private null|string $priceRating = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 5, scale: 3)]
    private null|string $managementRating = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 5, scale: 3)]
    private null|string $locationRating = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 5, scale: 2)]
    private null|string $transportRating = null;

    #[ORM\Column(type: Types::TEXT)]
    private string $explanation;

    #[ORM\ManyToOne(inversedBy: 'reviews')]
    private null|Address $address = null;

    public function __construct()
    {
        $this->createdAt = new DateTimeImmutable();
        $this->update();
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getExplanation(): string
    {
        return $this->explanation;
    }

    /**
     * @param string $explanation
     */
    public function setExplanation(string $explanation): void
    {
        $this->explanation = $explanation;
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

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    public function getAddress(): ?Address
    {
        return $this->address;
    }

    public function setAddress(?Address $address): self
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getUpdatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }

    /**
     * @param DateTimeImmutable $updatedAt
     */
    public function setUpdatedAt(DateTimeImmutable $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    #[ORM\PreUpdate]
    public function update(): void
    {
        $this->setUpdatedAt(new DateTimeImmutable());
    }

    public function getPriceRating(): ?string
    {
        return $this->priceRating;
    }

    public function setPriceRating(string $priceRating): self
    {
        $this->priceRating = $priceRating;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getGeneralRating(): ?string
    {
        return $this->generalRating;
    }

    /**
     * @param string|null $generalRating
     */
    public function setGeneralRating(?string $generalRating): void
    {
        $this->generalRating = $generalRating;
    }

    /**
     * @return string|null
     */
    public function getBuildingRating(): ?string
    {
        return $this->buildingRating;
    }

    /**
     * @param string|null $buildingRating
     */
    public function setBuildingRating(?string $buildingRating): void
    {
        $this->buildingRating = $buildingRating;
    }

    /**
     * @return string|null
     */
    public function getManagementRating(): ?string
    {
        return $this->managementRating;
    }

    /**
     * @param string|null $managementRating
     */
    public function setManagementRating(?string $managementRating): void
    {
        $this->managementRating = $managementRating;
    }

    /**
     * @return string|null
     */
    public function getLocationRating(): ?string
    {
        return $this->locationRating;
    }

    /**
     * @param string|null $locationRating
     */
    public function setLocationRating(?string $locationRating): void
    {
        $this->locationRating = $locationRating;
    }

    /**
     * @return string|null
     */
    public function getTransportRating(): ?string
    {
        return $this->transportRating;
    }

    /**
     * @param string|null $transportRating
     */
    public function setTransportRating(?string $transportRating): void
    {
        $this->transportRating = $transportRating;
    }

}
