<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dm_productos".
 *
 * @property string $dm_id_producto
 * @property string $dm_codigo codigo de barra
 * @property string $dm_nom_producto
 * @property int $dm_stock_min_compras Define la cantidad minima para comprar
 * @property double $dm_stock
 * @property int $dm_precio_compra
 * @property string $dm_porcentaje_ganancia
 * @property int $dm_precio_venta
 * @property int $dm_cajas_id
 *
 * @property DmVentas[] $dmVentas
 */
class DmProductos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dm_productos';
    }

    /**
     * @inheritdoc
     */
	public function rules()
	{
		return [
			[['dm_codigo', 'dm_nom_producto', 'dm_stock', 'dm_precio_compra', 'dm_porcentaje_ganancia', 'dm_precio_venta', 'dm_cajas_id'], 'required'],
			[['dm_stock_min_compras', 'dm_precio_compra', 'dm_precio_venta', 'dm_cajas_id'], 'integer'],
			[['dm_stock', 'dm_porcentaje_ganancia'], 'number'],
			[['dm_codigo', 'dm_nom_producto'], 'string', 'max' => 255],
			[['dm_codigo'], 'unique'],
		];
	}

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'dm_id_producto' => 'Dm Id Producto',
            'dm_codigo' => 'Código',
            'dm_nom_producto' => 'Nombre del producto',
            'dm_stock_min_compras' => 'Stock Min Compras',
            'dm_stock' => 'Stock',
            'dm_precio_compra' => 'Precio Compra',
            'dm_porcentaje_ganancia' => 'Porcentaje Ganancia',
            'dm_precio_venta' => 'Precio Venta',
            'dm_cajas_id' => 'Caja',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDmVentasProds()
    {
        return $this->hasMany(DmVentasProd::className(), ['dm_productos_dm_id_producto' => 'dm_id_producto']);
    }

    /**
     * Extrae productos por id de caja
     * @param integer $p_iIdCaja
     * @return array
     */
    static public function getProdByIdCaja( $p_iIdCaja ){
         return self::find()->where( [ 'dm_cajas_id' => $p_iIdCaja ] )->all();

    }

	/**
	 * Extrae productos a los cuales el código a sido generado
	 */
    static public function getProdCodGen() {
    	return self::find()->where( [ '<=', 'LENGTH(dm_codigo)', 5] )->all();

    }

	/**
	 * Valida si existe el codigo de barras en la base de datos
	 * @param $p_iCodigo
	 *
	 * @return bool
	 */
    static public function validateCode( $p_iCodigo ){

    	$result = self::find()->where( ['dm_codigo' => $p_iCodigo ] )->one();

    	if ( $result == null ){
    		return false;
	    }
	    else {
    		return true;
	    }

    }

	/**
	 * Get all prod order map
	 * @return array
	 */
    static public function getAllMap(){
	    return \yii\helpers\ArrayHelper::map( DmProductos::find()->all(), 'dm_id_producto', 'dm_nom_producto' );
    }


}
