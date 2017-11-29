<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dm_mermas".
 *
 * @property string $merma_id
 * @property integer $merma_cantidad
 * @property string $merma_datetime
 * @property string $dm_productos_id
 * @property integer $dm_cajas_id
 * @property string $merma_descripcion
 */
class DmMermas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dm_mermas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['merma_cantidad', 'merma_datetime', 'dm_productos_id', 'dm_cajas_id', 'merma_descripcion'], 'required'],
            [['merma_cantidad', 'dm_productos_id', 'dm_cajas_id'], 'integer'],
            [['merma_datetime'], 'safe'],
            [['merma_descripcion'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'merma_id' => 'Merma ID',
            'merma_cantidad' => 'Cantidad',
            'merma_datetime' => 'Fecha',
            'dm_productos_id' => 'Productos',
            'dm_cajas_id' => 'Caja',
            'merma_descripcion' => 'Descripción',
        ];
    }
}
