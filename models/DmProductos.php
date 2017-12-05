<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dm_productos".
 *
 * @property string $dm_id_producto
 * @property string $dm_codigo
 * @property string $dm_nom_producto
 * @property integer $dm_stock_min_compras
 * @property integer $dm_stock
 * @property integer $dm_precio_compra
 * @property string $dm_porcentaje_ganancia
 * @property integer $dm_precio_venta
 * @property integer $dm_cajas_id
 *
 * @property DmVentasProd[] $dmVentasProds
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
            [['dm_stock_min_compras', 'dm_stock', 'dm_precio_compra', 'dm_precio_venta', 'dm_cajas_id'], 'integer'],
            [['dm_porcentaje_ganancia'], 'number'],
            [['dm_codigo', 'dm_nom_producto'], 'string', 'max' => 255],
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



}
