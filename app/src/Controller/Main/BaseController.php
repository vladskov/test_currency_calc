<?php

namespace App\Controller\Main;

use App\Entity\Menu;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\Security\Core\Security;

class BaseController extends AbstractController
{
	private $security;
	protected $user;
	
	public function __construct( Security $security )
	{
		$this->security = $security;
		$this->user = ( @$security->getUser() ) ? $security->getUser()->getId() : 0;
	}
	
	public function renderDefault()
	{
		$forRender = array (
			'title' => 'Значение по умолчанию',
			'content' => ''
		);
		
		$forRender['menu_site']	= $this->getDoctrine()->getRepository( Menu::class )->findBy( ['is_active' => 1, 'is_admin' => 0], ['order_priority' => 'ASC' ]);
		
		return $forRender;
	}
}
