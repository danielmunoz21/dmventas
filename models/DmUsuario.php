<?php

namespace app\models;


use kartik\password\StrengthValidator;
use Yii;

/**
 * This is the model class for table "dm_usuario".
 *
 * @property string $dm_usuario_id
 * @property string $dm_usuario_nombre
 * @property string $dm_nom_login
 * @property string $dm_usuario_clave
 * @property integer $dm_tipo
 *
 * @property DmVentaDiaria[] $dmVentaDiarias
 */
class DmUsuario extends \yii\db\ActiveRecord
{


    public static $aTipos = [
        1 => 'Administrador',
        2 => 'Vendedor',
    ];


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dm_usuario';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['dm_usuario_nombre', 'dm_nom_login', 'dm_usuario_clave', 'dm_tipo'], 'required'],
            [['dm_usuario_id', 'dm_tipo'], 'integer'],
            [['dm_usuario_clave'], 'string'],
            [['dm_usuario_nombre', 'dm_nom_login'], 'string', 'max' => 45],
            [['dm_nom_login'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'dm_usuario_id' => 'Dm Usuario ID',
            'dm_usuario_nombre' => 'Nombre',
            'dm_nom_login'  => 'Login',
            'dm_usuario_clave' => 'Clave',
            'dm_tipo' => 'Tipo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDmVentaDiarias()
    {
        return $this->hasMany(DmVentaDiaria::className(), ['dm_usuario_dm_usuario_id' => 'dm_usuario_id']);
    }
}
