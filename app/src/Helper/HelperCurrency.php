<?php

namespace App\Helper;

class HelperCurrency
{
	
	static function get_euro_rate(  ) {
		$url 		= 'http://api.exchangeratesapi.io/v1/latest?access_key=b46af71cf12dd4e8cb4eab517b24a6fe&base=EUR&symbols=USD';
		$res		= json_decode( file_get_contents( $url ) );
		$currency_rate	= 0;
		if ( @$res->rates->USD ) {
			$currency_rate = $res->rates->USD;
		}
		
		return $currency_rate;
	}
}