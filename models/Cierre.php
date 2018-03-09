<?php

namespace app\models;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "cierre".
 *
 * @property string $nomturno
 * @property int $turnoid
 * @property string $ventadid
 * @property string $ventafecha
 * @property string $prodcod codigo de barra
 * @property string $nomprod
 * @property string $prodid
 * @property int $prodprecio
 * @property string $dm_venta_cantidad
 * @property string $cajanom
 * @property int $cajaid
 * @property string $userid
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
            [['turnoid', 'ventadid', 'prodid', 'prodprecio', 'dm_venta_cantidad', 'cajaid', 'userid'], 'integer'],
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
            'userid' => 'Userid',
        ];
    }

	/**
	 * Extrae y genera el cierre de turno del usuario
	 * @param $p_iIdTurno ID TURNO
	 * @param $p_fechaIn FECHA DE INICIO DE TURNO
	 * @param $p_fechaEn FECHA DE TERMINO DE TURNO
	 * @param $p_iUserId USUARIO QUE REGISTRO LAS VENTAS
	 *
	 * @return mixed
	 */
		static public function getAllCierres( $p_iIdTurno, $p_fechaIn, $p_fechaEn, $p_iUserId ){


			$query = new Query();
			$query->select( [ 'ventafecha', 'prodcod', 'nomprod', 'prodid', 'prodprecio AS total', 'SUM(dm_venta_cantidad) as cantidad', 'cajaid', 'prodprecio' ] )
			      ->from( 'cierre' )
			      ->where( [ 'turnoid' => $p_iIdTurno, 'userid' => $p_iUserId ] )
			      ->andWhere( [ 'between', 'ventafecha' ,$p_fechaIn, $p_fechaEn  ] )
			      ->addOrderBy( [ 'cajaid' => SORT_ASC ] )
			      ->groupBy( 'prodid' );

			return $query->all();


		}
}
