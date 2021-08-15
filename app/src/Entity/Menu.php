<?php

namespace App\Entity;

use App\Entity\Model;

use App\Repository\MenuRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MenuRepository::class)
 */
class Menu extends Model
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
	public $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
	public $name;

    /**
     * @ORM\Column(type="string", length=50)
     */
	public $link;

    /**
     * @ORM\Column(type="integer")
     */
	public $parent;
    
    /**
     * @ORM\Column(type="boolean")
     */
    public $is_admin;
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(string $link)
    {
        $this->link = $link;
    }

    public function getParent(): ?int
    {
        return $this->parent;
    }

    public function setParent(int $parent)
    {
        $this->parent = $parent;
    }
    
    
    public function getIsAdmin(): ?bool
    {
    	return $this->is_admin;
    }
    
    public function setIsAdmin(int $is_admin)
    {
    	$this->is_admin = $is_admin;
    }
}
