<?php

namespace App\Controller\Main;

use App\Controller\Main\BaseController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Page;

class HomeController extends BaseController
{
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
    	
    	$data					= $this->getDoctrine()->getRepository( Page::class )->findBy( array('is_active' => 1, 'is_default_user' => 1), array( 'id' => 'DESC' ), 1 ,0 );
    	$page					= ( isset( $data[0] ) )  ? $data[0] : array(  );
    	
    	$forRender	= parent::renderDefault(  );
    	if ( isset( $page->title ) ) {
    		$forRender['title']	= $page->title;
    	}
    	if ( isset( $page->content ) ) {
    		$forRender['content'] = $page->content;
    	}
    	
    	return $this->render('main/index.html.twig',  $forRender );
    }
    
}
