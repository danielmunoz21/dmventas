<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dm_cajas".
 *
 * @property integer $dm_cajas_id
 * @property string $dm_cajas_nombre
 *
 * @property DmVentaDiaria[] $dmVentaDiarias
 */
class DmCajas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dm_cajas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['dm_cajas_nombre'], 'required'],
            [['dm_cajas_nombre'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'dm_cajas_id' => 'Número',
            'dm_cajas_nombre' => 'Caja',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDmVentaDiarias()
    {
        return $this->hasMany(DmVentaDiaria::className(), ['dm_cajas_dm_cajas_id' => 'dm_cajas_id']);
    }

    static public function getAll(){
        return \yii\helpers\ArrayHelper::map( DmCajas::find()->all(), 'dm_cajas_id', 'dm_cajas_nombre' );
    }
}
