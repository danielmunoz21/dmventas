<?php

namespace app\models;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "cierre".
 *
 * @property string $nomturno
 * @property integer $turnoid
 * @property string $ventadid
 * @property string $ventafecha
 * @property string $prodcod
 * @property string $nomprod
 * @property string $prodid
 * @property integer $prodprecio
 * @property string $dm_venta_cantidad
 * @property string $cajanom
 * @property integer $cajaid
 */
class Cierre extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cierre';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['turnoid', 'ventafecha'], 'required'],
            [['turnoid', 'ventadid', 'prodid', 'prodprecio', 'dm_venta_cantidad', 'cajaid'], 'integer'],
            [['ventafecha'], 'safe'],
            [['nomturno', 'cajanom'], 'string', 'max' => 45],
            [['prodcod', 'nomprod'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'nomturno' => 'Nomturno',
            'turnoid' => 'Turnoid',
            'ventadid' => 'Ventadid',
            'ventafecha' => 'Ventafecha',
            'prodcod' => 'Prodcod',
            'nomprod' => 'Nomprod',
            'prodid' => 'Prodid',
            'prodprecio' => 'Prodprecio',
            'dm_venta_cantidad' => 'Dm Venta Cantidad',
            'cajanom' => 'Cajanom',
            'cajaid' => 'Cajaid',
        ];
    }


    
    static public function getAllCierres( $p_iIdTurno, $p_fechaIn, $p_fechaEn ){


        $query = new Query();
        $query->select( [ 'ventafecha', 'prodcod', 'nomprod', 'SUM(prodprecio) AS total', 'SUM(dm_venta_cantidad) as cantidad', 'cajaid' ] )
              ->from( 'cierre' )           
              ->where( [ 'turnoid' => $p_iIdTurno ] ) 
              ->andWhere( [ 'between', 'ventafecha' ,$p_fechaIn, $p_fechaEn  ] )
              ->addOrderBy( [ 'cajaid' => SORT_ASC ] )
              ->groupBy( 'prodid' );
              
        return $query->all();


    }



}
