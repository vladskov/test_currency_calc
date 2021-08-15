<?php

namespace App\Controller\Admin;

use App\Entity\Role;
use App\Form\RoleType;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Doctrine\Common\Persistence\PersistentObject;

class AdminRoleController extends AdminBaseController
{
	
	/**
	 * @Route("/admin/role", name="admin_role")
	 * @return Response
	 */
	public function index()
	{
		
		$roles					= $this->getDoctrine()->getRepository( Role::class )->findAll();
		$roles					= parent::prepareForList( $roles );
		
		$forRender			= parent::renderDefault();
		$forRender['roles']	= $roles;
		
		$forRender['title']	= 'Роли';
		$forRender['add_label'] = 'Добавить Роль';
		$forRender['add_link'] = 'admin_role_create';
		
		$forRender['list_block'] = $this->renderView( 'admin/role/list.html.twig',  $forRender );
		
		return $this->render( 'admin/admin.list.html.twig',  $forRender );
	}
	
	/**
	 * @Route("/admin/role/create", name="admin_role_create")
	 * @param Request $request
	 * @return RedirectResponse Response
	 */
	public function create( Request $request )
	{
		$role = new Role(  );
		$form = $this->createForm( RoleType::class, $role );
		$em = $this->getDoctrine()->getManager(  );
		$form->handleRequest( $request );
		
		if ( $form->isSubmitted(  ) AND $form->isValid(  ) ) {
			
			$role->setIsActive( 1 );
			$role->setCreateAtValue();
			$role->setUpdateAtValue();
			$role->setCreateBy( $this->user );
			$role->setUpdateBy( $this->user );
			$em->persist( $role );
			$em->flush(  );
			
			return $this->redirectToRoute( 'admin_role' );
		}
		
		$forRender = parent::renderDefault();
		$forRender['title'] = 'Форма создания роли';
		$forRender['form'] = $form->createView();
		return $this->render( 'admin/admin.form.html.twig', $forRender );
	}
	
	/**
	 * @Route("/admin/role/edit", name="admin_role_edit")
	 * @param Request $request
	 * @return RedirectResponse Response
	 */
	public function edit( Request $request )
	{
		$id = ( isset( $_REQUEST['id'] ) AND intval( $_REQUEST['id'] ) ) ? intval( $_REQUEST['id'] ) : false;
		
		if( !$id )
		{
			throw $this->createNotFoundException('No ID found');
		}
		
		$em = $this->getDoctrine()->getManager(  );
		
		$data = $this->getDoctrine()->getRepository( Role::class )->Find($id);
		
		$form = $this->createForm( RoleType::class, $data );
		$form->handleRequest( $request );
		
		if ( $form->isSubmitted(  ) AND $form->isValid(  ) ) {
			
			$data->setUpdateAtValue();
			$data->setUpdateBy( $this->user );
			$em->persist( $data );
			$em->flush(  );
			
			return $this->redirectToRoute( 'admin_role' );
		}
		
		$forRender = parent::renderDefault();
		$forRender['title'] = 'Форма редактирования роли';
		$forRender['form'] = $form->createView();
		return $this->render( 'admin/admin.form.html.twig', $forRender );
	}
	
	/**
	 * @Route("/admin/role/del", name="admin_role_del")
	 */
	public function del(  )
	{
		return parent::delItem( Role::class, 'admin_role' );
	}
	
	/**
	 * @Route("/admin/role/swap", name="admin_role_swap")
	 */
	public function swap(  )
	{
		return parent::swapItem( Role::class, 'admin_role');
	}
}
