<?php

namespace App\Controller\Admin;

use App\Controller\Admin\AdminBaseController;

use App\Entity\Menu;
use App\Form\MenuType;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Doctrine\Common\Persistence\PersistentObject;



class AdminMenuController extends AdminBaseController
{
    /**
     * @Route("/admin/menu", name="admin_menu")
     */
    public function index(): Response
    {
    	
    	$forRender	= parent::renderDefault(  );
    	
    	$menus					= $this->getDoctrine()->getRepository( Menu::class )->findAll();
    	$menus					= parent::prepareForList( $menus );
    	
    	if ( $menus ) { foreach ( $menus as $key => $unit ) {
    		$menus[ $key ]->menu_mode = ( @$unit->is_admin ) ? 'Админка' : 'Сайт';
    	} }
    	
    	$forRender['menus']	= $menus;
        
        $forRender['title']	= 'Меню';
        $forRender['add_label'] = 'Добавить элемент Меню';
        $forRender['add_link'] = 'admin_menu_create';
        
        $forRender['list_block'] = $this->renderView( 'admin/menu/list.html.twig',  $forRender );
        
        return $this->render( 'admin/admin.list.html.twig',  $forRender );
        
    }
    
    /**
     * @Route("/admin/menu/create", name="admin_menu_create")
     * @param Request $request
     * @return RedirectResponse Response
     */
    public function create( Request $request )
    {
    	$menu = new Menu(  );
    	$form = $this->createForm( MenuType::class, $menu );
    	$em = $this->getDoctrine()->getManager(  );
    	$form->handleRequest( $request );
    	
    	if ( $form->isSubmitted(  ) AND $form->isValid(  ) ) {
    		
    		$menu->setParent( 0 );
    		$menu->setCreateAtValue();
    		$menu->setUpdateAtValue();
    		$menu->setCreateBy( $this->user );
    		$menu->setUpdateBy( $this->user );
    		$em->persist( $menu );
    		$em->flush(  );
    		
    		return $this->redirectToRoute( 'admin_menu' );
    	}
    	
    	$forRender = parent::renderDefault();
    	$forRender['title'] = 'Форма создания меню';
    	$forRender['form'] = $form->createView();
    	return $this->render( 'admin/admin.form.html.twig', $forRender );
    }
    
    /**
     * @Route("/admin/menu/edit", name="admin_menu_edit")
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
    	
    	$data = $this->getDoctrine()->getRepository( Menu::class )->Find($id);
    	
    	$data->is_admin		= ( @$data->is_admin ) ? true : false;
    	
    	$form = $this->createForm( MenuType::class, $data );
    	$form->handleRequest( $request );
    	
    	if ( $form->isSubmitted(  ) AND $form->isValid(  ) ) {
    		
    		$data->setUpdateAtValue();
    		$data->setUpdateBy( $this->user );
    		$em->persist( $data );
    		$em->flush(  );
    		
    		return $this->redirectToRoute( 'admin_menu' );
    	}
    	
    	$forRender = parent::renderDefault();
    	$forRender['title'] = 'Форма редактирования меню';
    	$forRender['form'] = $form->createView();
    	return $this->render( 'admin/admin.form.html.twig', $forRender );
    }
    
    /**
     * @Route("/admin/menu/del", name="admin_menu_del")
     */
    public function del(  )
    {
    	return parent::delItem( Menu::class, 'admin_menu' );
    }
    
    /**
     * @Route("/admin/menu/swap", name="admin_menu_swap")
     */
    public function swap(  )
    {
		return parent::swapItem( Menu::class, 'admin_menu');
    }
    
}
