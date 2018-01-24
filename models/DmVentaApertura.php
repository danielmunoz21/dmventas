<?php

namespace app\models;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "dm_venta_apertura".
 *
 * @property integer $dm_apert_id
 * @property string $dm_apert_monto
 * @property string $dm_apert_fecha
 * @property string $dm_usuario_id
 */
class DmVentaApertura extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dm_venta_apertura';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['dm_apert_monto', 'dm_apert_fecha', 'dm_usuario_id'], 'required'],
            [['dm_apert_monto', 'dm_usuario_id'], 'integer'],
            [['dm_apert_fecha'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'dm_apert_id' => 'Dm Apert ID',
            'dm_apert_monto' => 'Monto',
            'dm_apert_fecha' => 'Dm Apert Fecha',
            'dm_usuario_id' => 'Dm Usuario ID',
        ];
    }


	/**
	 * Valida que la caja para el usuario y el dia especificado no se tenga registrada
	 * @param string $p_iUserId
	 * @param date $p_strFecha
	 *
	 * @return bool
	 */
    static public function valCajaExist( $p_iUserId, $p_strFecha ){

    	  //$oModel = self::find()->where([ 'dm_usuario_id' => $p_iUserId, 'dm_apert_fecha' => $p_strFecha ])->one();

	      $query = new Query();
	      $query->select( 'COUNT(*) as total' )
		          ->from( 'dm_venta_apertura' )
	            ->where( ['DATE_FORMAT(dm_apert_fecha, "%Y-%m-%d")' => $p_strFecha, 'dm_usuario_id' => $p_iUserId] );

	      $iCount = $query->one();

    	  if ( $iCount['total'] > 0 ){
    	  	return true;
	      }
	      else {
    	  	return false;
	      }

    }

	/**
	 * Extrae monto de apertura de una caja a partir de un usuario y la fecha entregada
	 * @param integer $p_iUserId
	 * @param string $p_strFecha
	 *
	 * @return bool|integer
	 */
    static public function getMontoApertura( $p_iUserId, $p_strFecha ){
	    $query = new Query();
	    $query->select( 'dm_apert_monto' )
	          ->from( 'dm_venta_apertura' )
	          ->where( ['DATE_FORMAT(dm_apert_fecha, "%Y-%m-%d")' => $p_strFecha, 'dm_usuario_id' => $p_iUserId] );

	    $row = $query->one();

	    if ( $row != false ){
		    return $row['dm_apert_monto'];
	    }
	    else {
		    return false;
	    }
    }

}
