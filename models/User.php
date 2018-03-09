<?php

namespace app\models;

date_default_timezone_set ( 'America/Santiago' );

use app\models\DmUsuario;
use app\models\DmVentaTurnos;
use app\models\Api;

class User extends \yii\base\Object implements \yii\web\IdentityInterface
{
    public $id;
    public $nombre;
    public $tipo;
    public $username;
    public $password;
    public $authKey;
    public $accessToken;
    public $id_turno;
   
    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        
        $oUsers = DmUsuario::findOne( $id );
        if ( !$oUsers ){
            return null;
        }
        else {


            $aUserInfo = [
                'id' => $oUsers->dm_usuario_id,
                'nombre' => $oUsers->dm_usuario_nombre,
                'username' => $oUsers->dm_nom_login,
                'tipo'  => $oUsers->dm_tipo,
                'id_turno' => isset($_SESSION['id_turno']) ? $_SESSION['id_turno'] : 0 ,
            ];

            return new static( $aUserInfo );
        }
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        foreach (self::$users as $user) {
            if ($user['accessToken'] === $token) {
                return new static($user);
            }
        }

        return null;
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username, $p_iIdTurno)
    {

        $oUsers = DmUsuario::findOne( [ 'dm_nom_login' => $username ] );
        if ( !$oUsers ){
            return null;
        }
        else {
	        $oSession = \Yii::$app->session;
	        $oSession->open();
            $aUserInfo = [
                'id' => $oUsers->dm_usuario_id,
                'nombre' => $oUsers->dm_usuario_nombre,
                'username' => $oUsers->dm_nom_login,
                'tipo'  => $oUsers->dm_tipo,
                'password' => $oUsers->dm_usuario_clave,
                'id_turno' => $p_iIdTurno,
            ];
            $oSession->set( 'id_turno', $p_iIdTurno );
            $oSession->close();
            return new static( $aUserInfo );
        }


        
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {

        $strEncryptPassword = Api::encryptPassword( $password );

        return $this->password === $strEncryptPassword;
    }

    public function setIdTurno( $p_iIdTurno ){
        $this->id_turno = $p_iIdTurno;
    }

    public function getIdTurno(){
        return $this->id_turno;
    }
}
