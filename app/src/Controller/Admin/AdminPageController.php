<?php

namespace App\Controller\Admin;

use App\Controller\Admin\AdminBaseController;

use App\Entity\Page;
use App\Form\PageType;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Doctrine\Common\Persistence\PersistentObject;

class AdminPageController extends AdminBaseController
{
    /**
     * @Route("/admin/page", name="admin_page")
     */
    public function index(): Response
    {
    	$forRender	= parent::renderDefault(  );
    	
    	$pages					= $this->getDoctrine()->getRepository( Page::class )->findAll();
    	$pages					= parent::prepareForList( $pages );
    	
    	$forRender['pages']	= $pages;
    	
    	$forRender['title']	= 'Страницы';
    	$forRender['add_label'] = 'Добавить страницу';
    	$forRender['add_link'] = 'admin_page_create';
    	
    	$forRender['list_block'] = $this->renderView( 'admin/page/list.html.twig',  $forRender );
    	
    	return $this->render( 'admin/admin.list.html.twig',  $forRender );
    }
    
    /**
     * @Route("/admin/page/create", name="admin_page_create")
     * @param Request $request
     * @return RedirectResponse Response
     */
    public function create( Request $request )
    {
    	$page = new Page(  );
    	$form = $this->createForm( PageType::class, $page );
    	$em = $this->getDoctrine()->getManager(  );
    	$form->handleRequest( $request );
    	
    	if ( $form->isSubmitted(  ) AND $form->isValid(  ) ) {
    		
    		$page->setCreateAtValue();
    		$page->setUpdateAtValue();
    		$page->setCreateBy( $this->user );
    		$page->setUpdateBy( $this->user );
    		$page->setOrderPriority( 0 );
    		$em->persist( $page );
    		$em->flush(  );
    		
    		return $this->redirectToRoute( 'admin_page' );
    	}
    	
    	$forRender = parent::renderDefault();
    	$forRender['title'] = 'Форма добавления страниц';
    	$forRender['form'] = $form->createView();
    	return $this->render( 'admin/admin.form.html.twig', $forRender );
    }
    
    /**
     * @Route("/admin/page/edit", name="admin_page_edit")
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
    	
    	$data = $this->getDoctrine()->getRepository( Page::class )->Find($id);
    	
    	$data->is_admin		= ( @$data->is_admin ) ? true : false;
    	
    	$form = $this->createForm( PageType::class, $data );
    	$form->handleRequest( $request );
    	
    	if ( $form->isSubmitted(  ) AND $form->isValid(  ) ) {
    		
    		$data->setUpdateAtValue();
    		$data->setUpdateBy( $this->user );
    		$em->persist( $data );
    		$em->flush(  );
    		
    		return $this->redirectToRoute( 'admin_page' );
    	}
    	
    	$forRender = parent::renderDefault();
    	$forRender['title'] = 'Форма редактирования страниц';
    	$forRender['form'] = $form->createView();
    	return $this->render( 'admin/admin.form.html.twig', $forRender );
    }
    
    /**
     * @Route("/admin/page/del", name="admin_page_del")
     */
    public function del(  )
    {
    	return parent::delItem( Page::class, 'admin_page' );
    }
    
    /**
     * @Route("/admin/page/swap", name="admin_page_swap")
     */
    public function swap(  )
    {
    	return parent::swapItem( Page::class, 'admin_page');
    }
}
