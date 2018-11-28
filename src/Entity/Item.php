<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Item
 *
 * @ORM\Table(name="item", indexes={@ORM\Index(name="fk_item_user1_idx", columns={"user_id"}), @ORM\Index(name="fk_item_status1_idx", columns={"status_id"}), @ORM\Index(name="fk_item_county1_idx", columns={"county_id"}), @ORM\Index(name="fk_item_category1_idx", columns={"category_id"})})
 * @ORM\Entity(repositoryClass="App\Repository\ItemRepository")
 */
class Item
{
    const MAX_RESULT = 4;
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var string|null
     *
     * @ORM\Column(name="photo", type="string", length=255, nullable=true)
     * @Assert\File(mimeTypes = {"image/jpeg", "image/png", "image/gif", "image/jpg"})
     */
    private $photo;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @var string|null
     *
     * @ORM\Column(name="address", type="string", length=255, nullable=true)
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=255, nullable=false)
     */
    private $city;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_begin", type="datetime", nullable=false)
     */
    private $dateBegin;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_end", type="datetime", nullable=true)
     */
    private $dateEnd;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $createdAt;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @var Category
     *
     * @ORM\ManyToOne(targetEntity="Category")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     * })
     */
    private $category;

    /**
     * @var County
     *
     * @ORM\ManyToOne(targetEntity="County")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="county_id", referencedColumnName="id")
     * })
     */
    private $county;

    /**
     * @var Status
     *
     * @ORM\ManyToOne(targetEntity="Status")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="status_id", referencedColumnName="id")
     * })
     */
    private $status;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

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

    public function getDateBegin(): ?\DateTimeInterface
    {
        return $this->dateBegin;
    }

    public function getDateBeginFormatted() : string
    {
        return $this->getDateBegin()->format("d/m/y");
    }

    public function setDateBegin(\DateTimeInterface $dateBegin): self
    {
        $this->dateBegin = $dateBegin;

        return $this;
    }

    public function getDateEnd(): ?\DateTimeInterface
    {
        return $this->dateEnd;
    }

    public function setDateEnd(?\DateTimeInterface $dateEnd): self
    {
        $this->dateEnd = $dateEnd;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getCounty(): ?County
    {
        return $this->county;
    }

    public function setCounty(?County $county): self
    {
        $this->county = $county;

        return $this;
    }

    public function getStatus(): ?Status
    {
        return $this->status;
    }

    public function setStatus(?Status $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValue()
    {
        $this->setCreatedAt(new \DateTime());
    }

    /**
     * @ORM\PostUpdate
     */
    public function setUpdatedAtValue()
    {
        $this->setUpdatedAt(new \DateTime());
    }

    public function __toString()
    {
        return $this->getName();
    }
}
