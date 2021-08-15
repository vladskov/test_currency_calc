<?php

namespace App\Controller\Admin;

use App\Controller\Admin\AdminBaseController;

use App\Entity\Currency;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Helper\HelperCurrency;

class AdminCurrencyController extends AdminBaseController
{
	
	/**
	 * @Route("/admin/currency", name="admin_currency")
	 * @return Response
	 */
	public function index(): Response
	{
		
		$forRender	= parent::renderDefault(  );
		
		$currencies					= $this->getDoctrine()->getRepository( Currency::class )->findAll();
		$currencies					= parent::prepareForList( $currencies );
		
		$forRender['currencies']	= $currencies;
		
		$forRender['title']	= 'Курсы валют';
		$forRender['add_label'] = 'Обновить курс';
		$forRender['add_link'] = 'admin_currency_load';
		
		$forRender['list_block'] = $this->renderView( 'admin/currency/list.html.twig',  $forRender );
		
		return $this->render( 'admin/admin.list.html.twig',  $forRender );
		
	}
	
	/**
	 * @Route("/admin/currency/load", name="admin_currency_load")
	 */
	public function load(): Response
	{
		$currency_rate	= HelperCurrency::get_euro_rate();
		
		$currency = new Currency(  );
		$em = $this->getDoctrine()->getManager(  );
		
		$currency->setEuro( $currency_rate );
		$currency->setCreateAtValue( );
		$currency->setUpdateAtValue( );
		$currency->setCreateBy( $this->user );
		$currency->setUpdateBy( $this->user );
		$currency->setIsActive( 1 );
		
		$em->persist( $currency );
		$em->flush(  );
		
		return $this->redirectToRoute( 'admin_currency' );
	}
	
	/**
	 * @Route("/admin/currency/del", name="admin_currency_del")
	 */
	public function del(  )
	{
		return parent::delItem( Currency::class, 'admin_currency' );
	}
	
	/**
	 * @Route("/admin/currency/swap", name="admin_currency_swap")
	 */
	public function swap(  )
	{
		return parent::swapItem( Currency::class, 'admin_currency');
	}
}
