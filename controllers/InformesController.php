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
use kartik\mpdf\Pdf;

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
				'only' => [ 'prodbajostock', 'ventasreg', 'view', 'prodbajostockpdf' ],
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

	public function actionProdbajostockpdf(){
		try{

			$dataProvider = DmProdSearch::prodbajostockpdf();

			if ( $dataProvider != false ) {
				$content = $this->renderPartial('prodbajostock_pdf', [ 'dataProvider' => $dataProvider ]);

				$oDate = new \DateTime('now');

				$pdf = new Pdf([
					'mode' => Pdf::MODE_UTF8, // leaner size using standard fonts
					'format' => Pdf::FORMAT_LETTER,
					'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
					'content' => $content,
					'options' => [
						'title' => 'PRODUCTOS BAJO STOCK',
						'subject' => 'LISTADO DE PRODUCTOS BAJOSTOCK'
					],
					'methods' => [
						'SetHeader' => ['DmVentas: ' . date("r")],
						'SetFooter' => ['|Página {PAGENO}|'],
					],
					'destination' => Pdf::DEST_BROWSER,
					'filename'=> 'PRODBAJOSTOCK_'.$oDate->format('dmYHis').'.pdf'
				]);

				// return the pdf output as per the destination setting
				$pdf->render();
			}

		}
		catch ( \Exception $e ){
			error_log( 'DEBUG INFORMES CONTROLLER PRODBAJOSTOCK PDF ' . $e->getMessage() );
		}

	}

}