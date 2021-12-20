<?php

namespace App\Entity;

use App\Repository\RelationAlbumAndImageRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RelationAlbumAndImageRepository::class)
 */
class RelationAlbumAndImage
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=Img::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $id_image;

    /**
     * @ORM\ManyToOne(targetEntity=Album::class, inversedBy="images")
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_album;

    public function getId(): int
    {
        return $this->id;
    }

    public function getIdImage(): Img
    {
        return $this->id_image;
    }

    public function setIdImage(Img $id_image): self
    {
        $this->id_image = $id_image;

        return $this;
    }

    public function getIdAlbum(): Album
    {
        return $this->id_album;
    }

    public function setIdAlbum(Album $id_album): self
    {
        $this->id_album = $id_album;

        return $this;
    }
}
