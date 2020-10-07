<?php

namespace App\Helpers;

class Helper
{
    public static function validar_recaptcha($letras, $token){

    	$caracteres = ['0','1','2','3','4','5','6','7','8','9','@','#','$','%','*','+','a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','v','w','x','y','z','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','V','W','X','Y','Z'];

		$valor_validacion = true;

		$letras = str_split($letras);
		$tokens = str_split($token,32);

		$posicion_en_palabra = 0;

		foreach ($tokens as $token) {
			$posicion_en_arreglo = array_search($letras[$posicion_en_palabra], $caracteres);
			$token_a_validar = $token;
			$token_origen = md5(date('h').$caracteres[$posicion_en_arreglo].$posicion_en_palabra.$posicion_en_arreglo);
			if ($token_origen == $token_a_validar AND $valor_validacion) {
				$valor_validacion = true;
			}else{
				$valor_validacion = false;
			}
			$posicion_en_palabra++;
		}

		$validacion_completa = $valor_validacion ? 'exito' :'error';

		return $validacion_completa;
    }

    public static function obtener_recaptcha(){

		$caracteres = ['0','1','2','3','4','5','6','7','8','9','@','#','$','%','*','+','a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','v','w','x','y','z','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','V','W','X','Y','Z'];

		$posiciones = 65;
		$array_ordenado = [];
		$array_desordenado = [];
		$posiciones_usadas =[''];
		$posicion='';

		for ($i=0; $i < 6; $i++) {

			while (in_array($posicion, $posiciones_usadas)) {
				$posicion = rand(1, $posiciones);
			}
			array_push($array_ordenado, $caracteres[$posicion]);
			$letra = [ 'letra' => $caracteres[$posicion],
					   'token' => md5(date('h').$caracteres[$posicion].$i.$posicion)];
			array_push($array_desordenado,$letra);
			array_push($posiciones_usadas, $posicion);
		}

		shuffle($array_desordenado);
		shuffle($array_desordenado);
		$datosValidacion = [
			'ordenado' => $array_ordenado,
			'desordenado' => $array_desordenado,
		];

		return $datosValidacion;
    }
}