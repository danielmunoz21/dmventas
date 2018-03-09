<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Query;
/**
 * This is the model class for table "dm_venta_turnos".
 *
 * @property integer $dm_venta_turnos_id
 * @property string $dm_nombre
 * @property string $dm_venta_hora_inicio
 * @property string $dm_venta_hora_termino
 *
 * @property DmVentaDiaria[] $dmVentaDiarias
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
            [['dm_nombre', 'dm_venta_hora_inicio', 'dm_venta_hora_termino'], 'required'],
            [['dm_venta_hora_inicio', 'dm_venta_hora_termino'], 'safe'],
            [['dm_nombre'], 'string', 'max' => 45],
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    /*public function getDmVentaDiarias()
    {
        return $this->hasMany(DmVentaDiaria::className(), ['dm_venta_turnos_dm_venta_turnos_id' => 'dm_venta_turnos_id']);
    }*/

    static public function getTurnoByHora( $p_strTurno ){

        $query = new Query();

        $results = $query->select( '*' )
                ->from ( self::tableName() )
                ->where( 'TIME_FORMAT(dm_venta_hora_inicio, "%r") >= TIME_FORMAT("'. $p_strTurno.'", "%r" )'  )
                ->andWhere( 'TIME_FORMAT(dm_venta_hora_termino, "%r") <= TIME_FORMAT("'. $p_strTurno.'", "%r" )'  )
                ->one();

     
        echo '<pre>';
            print_r( $results );
        echo '</pre>';

            
        /*$dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);    

        $query->andFilterWhere([ 'AND', [
                [ '>=', 'dm_venta_hora_inicio', $p_strTurno ],
                [ '=<', 'dm_venta_hora_termino', $p_strTurno ],
            ] ]);
        

        
        return $dataProvider;*/
    }

    static public function getAll(){
	    return \yii\helpers\ArrayHelper::map( DmVentaTurnos::find()->all(), 'dm_venta_turnos_id', 'dm_nombre' );
    }
}
