<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dm_ventas".
 *
 * @property string $dm_venta_id
 * @property string $dm_venta_cantidad
 * @property string $dm_productos_dm_id_producto
 * @property string $dm_venta_diario_dm_venta_diario_id
 *
 * @property DmProductos $dmProductosDmIdProducto
 * @property DmVentaDiario $dmVentaDiarioDmVentaDiario
 */
class DmVentas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dm_ventas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['dm_venta_cantidad', 'dm_productos_dm_id_producto', 'dm_venta_diario_dm_venta_diario_id'], 'required'],
            [['dm_venta_cantidad', 'dm_productos_dm_id_producto', 'dm_venta_diario_dm_venta_diario_id'], 'integer'],
            [['dm_productos_dm_id_producto'], 'exist', 'skipOnError' => true, 'targetClass' => DmProductos::className(), 'targetAttribute' => ['dm_productos_dm_id_producto' => 'dm_id_producto']],
            [['dm_venta_diario_dm_venta_diario_id'], 'exist', 'skipOnError' => true, 'targetClass' => DmVentaDiario::className(), 'targetAttribute' => ['dm_venta_diario_dm_venta_diario_id' => 'dm_venta_diario_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'dm_venta_id' => 'Dm Venta ID',
            'dm_venta_cantidad' => 'Dm Venta Cantidad',
            'dm_productos_dm_id_producto' => 'Dm Productos Dm Id Producto',
            'dm_venta_diario_dm_venta_diario_id' => 'Dm Venta Diario Dm Venta Diario ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDmProductosDmIdProducto()
    {
        return $this->hasOne(DmProductos::className(), ['dm_id_producto' => 'dm_productos_dm_id_producto']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDmVentaDiarioDmVentaDiario()
    {
        return $this->hasOne(DmVentaDiario::className(), ['dm_venta_diario_id' => 'dm_venta_diario_dm_venta_diario_id']);
    }
}
