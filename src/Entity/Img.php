<?php

namespace App\Entity;

use App\Repository\ImgRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ImgRepository::class)
 */
class Img
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @ORM\OneToOne(targetEntity=RelationAlbumAndImage::class, cascade={"persist", "remove"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image_name;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_create;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $user_create;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImageName(): ?string
    {
        return $this->image_name;
    }

    public function setImageName(string $image_name): self
    {
        $this->image_name = $image_name;

        return $this;
    }

    public function getDateCreate(): ?\DateTimeInterface
    {
        return $this->date_create;
    }

    public function setDateCreate(\DateTimeInterface $date_create): self
    {
        $this->date_create = $date_create;

        return $this;
    }

    public function getUserCreate(): ?string
    {
        return $this->user_create;
    }

    public function setUserCreate(string $user_create): self
    {
        $this->user_create = $user_create;

        return $this;
    }
}
