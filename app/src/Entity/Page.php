<?php

namespace App\Entity;

use App\Entity\Model;

use App\Repository\PageRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PageRepository::class)
 */
class Page extends Model
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    public $title;

    /**
     * @ORM\Column(type="string", length=50)
     */
    public $link;

    /**
     * @ORM\Column(type="text")
     */
    public $content;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $is_default_admin;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $is_default_user;

    public function getId(): ?int
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

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(string $link): self
    {
        $this->link = $link;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getIsDefaultAdmin(): ?bool
    {
        return $this->is_default_admin;
    }

    public function setIsDefaultAdmin(?bool $is_default_admin): self
    {
        $this->is_default_admin = $is_default_admin;

        return $this;
    }

    public function getIsDefaultUser(): ?bool
    {
        return $this->is_default_user;
    }

    public function setIsDefaultUser(?bool $is_default_user): self
    {
        $this->is_default_user = $is_default_user;

        return $this;
    }
}
