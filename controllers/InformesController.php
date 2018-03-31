<?php
/**
 * Created by PhpStorm.
 * User: DANIEL
 * Date: 14-03-2018
 * Time: 23:36
 */

namespace app\controllers;

use app\models\DmUsuario;
use app\models\DmVentaTurnos;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

use app\models\DmProductos;
use app\models\DmProdSearch;
use app\models\DmCajas;
use app\models\DmCajasSearch;
use app\models\DmVentaDiario;
use app\models\DmVentaDSearch;
use app\models\DmVentaSearch;

class InformesController extends Controller{

	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		return [
			'verbs' => [
				'class' => VerbFilter::className(),
				'actions' => [
					'delete' => ['POST'],
				],
			],
			'access' => [
				'class' => \yii\filters\AccessControl::className(),
				'only' => [ 'prodbajostock', 'ventasreg', 'view' ],
				'rules' => [
					// allow authenticated users
					[
						'allow' => true,
						'roles' => ['@'],

					],
				],
			],
		];
	}

	public function actionProdbajostock(){

		$searchModel = new DmProdSearch();
		$dataProvider = $searchModel->searchprodbajostock(Yii::$app->request->queryParams);
		$aCajas = DmCajas::getAll();

		return $this->render('prodbajostock', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
			'aCajas' => $aCajas,
		]);

	}

	public function actionVentasreg(){

		$searchModel = new DmVentaDSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);


		return $this->render( '_ventas', [
			'dataProvider' => $dataProvider,
			'searchModel' => $searchModel
		]);

	}

	public function actionView($id){
		try {
			$modelDiario = DmVentaDiario::findOne( $id );

			$aUsuarios = DmUsuario::getAll();
			$aTurnos = DmVentaTurnos::getAll();

			$oFecha = new \DateTime( date( 'Y-m-d H:i:s', strtotime( $modelDiario->dm_venta_datetime ) ) );

			$searchVenta = new DmVentaSearch();
			$searchVenta->dm_venta_diario_dm_venta_diario_id = $modelDiario->dm_venta_diario_id;

			$dataProvider = $searchVenta->search(Yii::$app->request->queryParams);

			return $this->render(
				'_detail_view', [
					'modelDiario' => $modelDiario,
					'strFecha' => $oFecha->format( 'd/m/Y H:i:s' ),
					'aUsuarios' => $aUsuarios,
					'aTurnos' => $aTurnos,
					'dataProvider' => $dataProvider,
					'searchModel' => $searchVenta,

				]
			);
		}
		catch( \Exception $e ){
			error_log( 'DEBUG INFORMES CONTROLLER ACTION VIEW ' . $e->getMessage() );
			throw new NotFoundHttpException('Error.' . $e->getMessage());
		}

	}

}