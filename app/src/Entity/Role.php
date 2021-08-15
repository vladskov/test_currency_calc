<?php

namespace App\Entity;

use App\Entity\Model;

use App\Repository\RoleRepository;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity(repositoryClass=RoleRepository::class)
 */
class Role  extends Model
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=30, unique=true)
     */
    private $code;

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
    
    
    public function getcode(): ?string
    {
    	return $this->code;
    }
    
    public function setCode(string $code): self
    {
    	$this->code = $code;
    	
    	return $this;
    }
	
    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see RoleInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see RoleInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the role, clear it here
        // $this->plainPassword = null;
    }
    

}
