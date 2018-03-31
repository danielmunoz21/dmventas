<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Query;
/**
 * This is the model class for table "dm_venta_turnos".
 *
 * @property int $dm_venta_turnos_id
 * @property string $dm_nombre
 * @property string $dm_venta_hora_inicio
 * @property string $dm_venta_hora_termino
 * @property int $dm_venta_cierre_sig_dia
 * @property int $dm_venta_turno_orden
 */
class DmVentaTurnos extends \yii\db\ActiveRecord
{
	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'dm_venta_turnos';
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['dm_nombre', 'dm_venta_hora_inicio', 'dm_venta_hora_termino', 'dm_venta_turno_orden'], 'required'],
			[['dm_venta_hora_inicio', 'dm_venta_hora_termino'], 'safe'],
			[['dm_nombre'], 'string', 'max' => 45],
			[['dm_venta_cierre_sig_dia', 'dm_venta_turno_orden'], 'string', 'max' => 1],
		];
	}



    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'dm_venta_turnos_id' => 'ID',
            'dm_nombre' => 'Nombre',
            'dm_venta_hora_inicio' => 'Hora Inicio',
            'dm_venta_hora_termino' => 'Hora Termino',
            'dm_venta_cierre_sig_dia' => 'Cierra el día siguiente',
            'dm_venta_turno_orden' => 'Orden de turno',
        ];
    }


    static public function getAll(){
	    return \yii\helpers\ArrayHelper::map( DmVentaTurnos::find()->all(), 'dm_venta_turnos_id', 'dm_nombre' );
    }

	/**
	 * @return bool|false|null|string
	 */
    static public function getIdTurnNight(){
    	$query = new Query();
    	$iTurno = $query->select( 'dm_venta_turnos_id' )
		    ->from( 'dm_venta_turnos' )
		    ->where([ 'LIKE', 'dm_nombre', 'noche' ])
	      ->scalar();

    	if ( $iTurno == false ) {
    		return false;
	    }
	    else {
    		return $iTurno;
	    }
    }

	/**
	 * Verifica si el turno corresponde a uno que se cierra el día siguiente.
	 * @return array
	 */
    static public function opciones(){
    	return [ 0 => 'No', 1 => 'Si' ];
    }


}
