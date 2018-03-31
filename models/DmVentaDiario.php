<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dm_venta_diario".
 *
 * @property string $dm_venta_diario_id
 * @property string $dm_venta_total
 * @property string $dm_venta_datetime
 * @property string $dm_usuario_dm_usuario_id
 * @property integer $dm_venta_turno_id
 *
 * @property DmUsuario $dmUsuarioDmUsuario
 * @property DmVentas[] $dmVentas
 */
class DmVentaDiario extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dm_venta_diario';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['dm_venta_total', 'dm_venta_datetime', 'dm_usuario_dm_usuario_id', 'dm_venta_turno_id'], 'required'],
            [['dm_venta_total', 'dm_usuario_dm_usuario_id', 'dm_venta_turno_id'], 'integer'],
            [['dm_venta_datetime'], 'safe'],
            [['dm_usuario_dm_usuario_id'], 'exist', 'skipOnError' => true, 'targetClass' => DmUsuario::className(), 'targetAttribute' => ['dm_usuario_dm_usuario_id' => 'dm_usuario_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'dm_venta_diario_id' => 'Dm Venta Diario ID',
            'dm_venta_total' => 'Total',
            'dm_venta_datetime' => 'Fecha',
            'dm_usuario_dm_usuario_id' => 'Usuario',
            'dm_venta_turno_id' => 'Turno',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDmUsuarioDmUsuario()
    {
        return $this->hasOne(DmUsuario::className(), ['dm_usuario_id' => 'dm_usuario_dm_usuario_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDmVentas()
    {
        return $this->hasMany(DmVentas::className(), ['dm_venta_diario_dm_venta_diario_id' => 'dm_venta_diario_id']);
    }
}
