<?php

namespace app\controllers;

use app\models\DmVentaApertura;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\DmVentaTurnos;


class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {

        $aTurnos = \yii\helpers\ArrayHelper::map( DmVentaTurnos::find()->all(), 'dm_venta_turnos_id', 'dm_nombre' );

        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {

        	  //valido si el usuario ya registro su caja para el día de hoy
	          $user = Yii::$app->user->identity;

	          $modelTurno = DmVentaTurnos::findOne( $user->id_turno );
	          $oDtActual = new \DateTime( date('Y-m-d' ) );
	          if ( $modelTurno->dm_venta_hora_inicio > $modelTurno->dm_venta_hora_termino ){
	          	$oDtActual->modify( '-1day' );
	          }
	          
						$bValido = DmVentaApertura::valCajaExist( $user->getId(), $oDtActual->format( 'Y-m-d' ), $user->id_turno );
						if ( $bValido ){

							$iIdapertura = DmVentaApertura::getIdApert( $user->getId(), $oDtActual->format( 'Y-m-d' ), $user->id_turno );

							$oSession = Yii::$app->session;
							$oSession->open();
								$oSession->set( 'id_apertura', $iIdapertura );
							$oSession->close();
							return $this->goBack();
						}
						else {
							return $this->redirect( ['/apertura/create'] );
						}

        }


        return $this->render('login', [
            'model' => $model,
            'aTurnos' => $aTurnos
        ]);
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
		    $oSession = Yii::$app->session;
			    $oSession->open();
			    $oSession->destroy();
		    $oSession->close();
        return $this->goHome();
    }

   
}
