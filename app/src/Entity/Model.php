<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

class Model {
	
	/**
	 * @ORM\Column(type="boolean", nullable=true)
	 */
	public $is_active;
	
	/**
	 * @var \DateTime $created_at
	 *
	 * @ORM\Column(type="datetime")
	 */
	public $create_at;
	
	/**
	 * @var \DateTime $updated_at
	 *
	 * @ORM\Column(type="datetime")
	 */
	public $update_at;
	
	/**
	 * @ORM\Column(type="integer", nullable=true)
	 */
	public $create_by;
	
	/**
	 * @ORM\Column(type="integer", nullable=true)
	 */
	public $update_by;
	
	/**
	 * @ORM\Column(type="integer", nullable=true)
	 */
	public $order_priority;
	
	public function getCreateAt(): ?\DateTimeImmutable
	{
		return $this->create_at;
	}
	
	public function setCreateAt(\DateTimeImmutable $create_at)
	{
		$this->create_at = $create_at;
	}
	
	public function setCreateAtValue( )
	{
		$this->create_at = new \DateTimeImmutable(  );
	}
	
	public function getUpdateAt(): ?\DateTimeImmutable
	{
		return $this->update_at;
	}
	
	public function setUpdateAt(\DateTimeImmutable $update_at)
	{
		$this->update_at = $update_at;
	}
	
	public function setUpdateAtValue( )
	{
		$this->update_at = new \DateTimeImmutable(  );
	}
	
	/**
	 * @see ActiveInterface
	 */
	public function getIsActive(): bool
	{
		return $this->is_active;
	}
	
	public function setIsActive(bool $is_active)
	{
		$this->is_active = $is_active;
	}
	
	public function getCreateBy(): ?int
	{
		return $this->create_by;
	}
	
	public function setCreateBy(int $create_by)
	{
		$this->create_by = $create_by;
	}
	public function setCreateByValue()
	{
		$this->create_by = 1;
	}
	
	public function getUpdateBy(): ?int
	{
		return $this->update_by;
	}
	
	public function setUpdateBy(int $update_by)
	{
		$this->update_by = $update_by;
	}
	
	public function setUpdateByValue()
	{
		$this->update_by = 1;
	}
	
	public function getOrderPriority(): ?int
	{
		return $this->order_priority;
	}
	
	public function setOrderPriority(int $order_priority)
	{
		$this->order_priority = $order_priority;
	}
}