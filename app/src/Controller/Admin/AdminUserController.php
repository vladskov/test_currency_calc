<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\UserType;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Doctrine\Common\Persistence\PersistentObject;

class AdminUserController extends AdminBaseController
{
	
	/**
	 * @Route("/admin/user", name="admin_user")
	 * @return Response
	 */
	public function index()
	{
		
		$forRender			= parent::renderDefault();
		
		$users					= $this->getDoctrine()->getRepository( User::class )->findAll();
		$users					= parent::prepareForList( $users );
		
		$forRender['users']	= $users;
		
		$forRender['title']	= 'Пользователи';
		$forRender['add_label'] = 'Добавить Пользователя';
		$forRender['add_link'] = 'admin_user_create';
		
		$forRender['list_block'] = $this->renderView( 'admin/user/list.html.twig',  $forRender );
		
		return $this->render( 'admin/admin.list.html.twig',  $forRender );
	}
	
	/**
	 * @Route("/admin/user/create", name="admin_user_create")
	 * @param Request $request
	 * @param UserPasswordEncoderInterface $passwordEncoder
	 * @return RedirectResponse Response
	 */
	public function create( Request $request, UserPasswordEncoderInterface $passwordEncoder )
	{
		$user = new User(  );
		$form = $this->createForm( UserType::class, $user );
		$em = $this->getDoctrine()->getManager(  );
		$form->handleRequest( $request );
		
		if ( $form->isSubmitted(  ) AND $form->isValid(  ) ) {
			$password = $passwordEncoder->encodePassword( $user, $user->getPlainPassword(  ) );
			$user->setPassword( $password );
			$user->setRoles( array( 'ROLE_ADMIN' ) );
			$user->setCreateAtValue(  );
			$user->setUpdateAtValue(  );
			$user->setIsActive( 1 );
			
			$em->persist( $user );
			$em->flush(  );
			
			return $this->redirectToRoute( 'admin_user' );
		}
		
		$forRender = parent::renderDefault();
		$forRender['title'] = 'Форма создания пользователя';
		$forRender['form'] = $form->createView();
		return $this->render( 'admin/admin.form.html.twig', $forRender );
	}
	
	/**
	 * @Route("/admin/user/edit", name="admin_user_edit")
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
		
		$data = $this->getDoctrine()->getRepository( User::class )->Find($id);
		
		$form = $this->createForm( UserType::class, $data );
		$form->handleRequest( $request );
		
		if ( $form->isSubmitted(  ) AND $form->isValid(  ) ) {
			
			$data->setUpdateAtValue();
			$data->setUpdateBy( $this->user );
			$em->persist( $data );
			$em->flush(  );
			
			return $this->redirectToRoute( 'admin_user' );
		}
		
		$forRender = parent::renderDefault();
		$forRender['title'] = 'Форма редактирования пользователя';
		$forRender['form'] = $form->createView();
		return $this->render( 'admin/admin.form.html.twig', $forRender );
	}
	
	/**
	 * @Route("/admin/user/del", name="admin_user_del")
	 */
	public function del(  )
	{
		return parent::delItem( User::class, 'admin_user' );
	}
	
	/**
	 * @Route("/admin/user/swap", name="admin_user_swap")
	 */
	public function swap(  )
	{
		return parent::swapItem( User::class, 'admin_user');
	}
}
