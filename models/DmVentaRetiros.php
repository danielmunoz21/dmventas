<?php

namespace app\models;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "dm_venta_retiros".
 *
 * @property string $retiro_id
 * @property string $retiro_monto
 * @property string $retiro_datetime
 * @property int $dm_cajas_dm_cajas_id
 * @property string $dm_usuario_dm_usuario_id
 * @property int $dm_venta_turnos_dm_venta_turnos_id
 */
class DmVentaRetiros extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dm_venta_retiros';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['retiro_monto', 'retiro_datetime', 'dm_cajas_dm_cajas_id', 'dm_usuario_dm_usuario_id', 'dm_venta_turnos_dm_venta_turnos_id'], 'required'],
            [['retiro_monto', 'dm_cajas_dm_cajas_id', 'dm_usuario_dm_usuario_id', 'dm_venta_turnos_dm_venta_turnos_id'], 'integer'],
            [['retiro_datetime'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'retiro_id' => 'Retiro ID',
            'retiro_monto' => 'Monto',
            'retiro_datetime' => 'Fecha',
            'dm_cajas_dm_cajas_id' => 'Caja',
            'dm_usuario_dm_usuario_id' => 'Usuario',
            'dm_venta_turnos_dm_venta_turnos_id' => 'Turno',
        ];
    }


    static public function getMountbyData( $p_iUserId, $p_iTurnoId, $p_iCajasId, $p_strFecha ){

	    $query = new Query();

	    $query->select( ['SUM(retiro_monto) as retiro'] )
		     ->from( 'dm_venta_retiros' )
		     ->where( [
		     	        'DATE_FORMAT(retiro_datetime, "%Y-%m-%d")' => $p_strFecha,
		     	        'dm_cajas_dm_cajas_id' => $p_iCajasId,
		     	        'dm_usuario_dm_usuario_id' => $p_iUserId,
		     	        'dm_venta_turnos_dm_venta_turnos_id' => $p_iTurnoId
		            ] );

	    $data =  $query->scalar();
			if ( !empty( $data ) ){
				return $data;
			}
			else{
				return 0;
			}

    }
}
