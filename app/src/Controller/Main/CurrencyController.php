<?php

namespace App\Controller\Main;

use App\Entity\Currency;

use App\Controller\Main\CurrencyController;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Helper\HelperCurrency;


class CurrencyController extends BaseController
{
    /**
     * @Route("/currency/load", name="currency_load")
     */
    public function index(): Response
    {
    	$forRender	= parent::renderDefault(  );
    	$forRender['title'] = 'Загрузка Курсов Валют';
    	
    	$currency_rate = HelperCurrency::get_euro_rate(  );
    	
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
    	
    	return $this->render('main/index.html.twig',  $forRender );
    }
    
    /**
     * @Route("/calc", name="calc")
     */
    public function calc(): Response
    {
    	$forRender	= parent::renderDefault(  );
    	$forRender['title'] = 'Конвертор валют';
    	
    	$data					= $this->getDoctrine()->getRepository( Currency::class )->findBy( array('is_active' => 1), array( 'id' => 'DESC' ), 1 ,0 );
    	$rate						= ( isset( $data[0] ) ) ? $data[0] : 0;
    	
    	$forRender['rates']	= $rate;
    	
    	return $this->render('main/calc/index.html.twig',  $forRender );
    }
}
