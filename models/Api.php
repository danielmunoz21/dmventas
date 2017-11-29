<?php

namespace app\models;

class Api{


	/**
	 * Encrypt password
	 * @param  string $p_strClave 
	 * @return string
	 */
	static public function encryptPassword( $p_strClave ){

        $apiKey = \Yii::$app->params['secretPhrass'];

        $passCrypt = hash_hmac( 'ripemd160', $p_strClave , $apiKey );

        return $passCrypt;

    }
}