<?php

namespace App\Controller\Admin;

use App\Entity\Menu;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Security\Core\Security;

class AdminBaseController extends AbstractController
{
	
	private $security;
	protected $user;
	public function __construct( Security $security )
	{
		$this->security = $security;
		$this->user = $security->getUser()->getId();
	}
	
	public function renderDefault()
	{
		$forRender = array (
				'title' => 'Админ Базовый',
				'content' => ''
		);
		
		$forRender['menu_admin']	= $this->getDoctrine()->getRepository( Menu::class )->findBy( ['is_active' => 1, 'is_admin' => 1], ['order_priority' => 'ASC' ]);
		
		return $forRender;
	}
	
	public function prepareForList( $list ) {
		if ( $list ) { $c1 = 0; foreach ( $list as $key => $unit ) { $list[ $key ]->list_class = ( ++$c1%2 ) ? 'list-group-item-primary' : 'list-group-item-secondary'; $list[ $key ]->active_status = ( @$unit->is_active ) ? 'status_green' : 'status_red'; } }
		return $list;
	}
	
	
	public function delItem( $entity_class, $redirect_link )
	{
		$id = ( isset( $_GET['id'] ) AND intval( $_GET['id'] ) ) ? intval( $_GET['id'] ) : false;
		
		if( !$id )
		{
			throw $this->createNotFoundException('No ID found');
		}
		$em = $this->getDoctrine()->getManager();
		
		$data = $this->getDoctrine()->getRepository( $entity_class )->Find($id);
		
		if($data != null)
		{
			$em->remove($data);
			$em->flush();
		}
		
		return $this->redirectToRoute( $redirect_link );
		
	}
	
	public function swapItem( $entity_class, $redirect_link )
	{
		$id = ( isset( $_GET['id'] ) AND intval( $_GET['id'] ) ) ? intval( $_GET['id'] ) : false;
		
		if( !$id )
		{
			throw $this->createNotFoundException('No ID found');
		}
		$em = $this->getDoctrine()->getManager();
		
		$data = $this->getDoctrine()->getRepository( $entity_class )->Find($id);
		
		if($data != null)
		{
			$page->setUpdateAtValue();
			$page->setUpdateBy( $this->user );
			$data->setIsActive( !$data->is_active );
			$em->persist($data);
			$em->flush();
		}
		
		return $this->redirectToRoute( $redirect_link );
	}
}
