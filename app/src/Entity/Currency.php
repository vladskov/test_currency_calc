<?php

namespace App\Entity;

use App\Entity\Model;

use App\Repository\CurrencyRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CurrencyRepository::class)
 */
class Currency extends Model 
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $euro;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEuro(): ?string
    {
        return $this->euro;
    }

    public function setEuro(string $euro): self
    {
        $this->euro = $euro;

        return $this;
    }
    
    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see CurrencyInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see CurrencyInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the Currency, clear it here
        // $this->plainPassword = null;
    }
}
