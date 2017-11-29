<?php

namespace app\controllers;

use Yii;
use app\models\DmMermas;
use app\models\DmMermasS;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use app\models\DmProductos;
use app\models\DmCajas;
use app\models\DmProdSearch;


/**
 * MermasController implements the CRUD actions for DmMermas model.
 */
class MermasController extends Controller
{
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
                'only' => ['create', 'update', 'view', 'delete', 'index', 'findprod'],
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

    /**
     * Lists all DmMermas models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DmMermasS();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single DmMermas model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new DmMermas model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new DmMermas();
        $model->merma_datetime = date( 'Y-m-d H:i:s' );
        //$aProductos = ArrayHelper::map( DmProductos::find()->asArray()->all(), 'dm_id_producto', 'dm_nom_producto' );
        $aCajas = ArrayHelper::map( DmCajas::find()->asArray()->all(), 'dm_cajas_id', 'dm_cajas_nombre'  );
        
        $aProductos = [];
        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            //descuento stock del producto
            $oModelProd = DmProductos::findOne( $model->dm_productos_id );
            $oModelProd->dm_stock = $oModelProd->dm_stock - $model->merma_cantidad;
            $oModelProd->save();

            return $this->redirect(['view', 'id' => $model->merma_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'aProductos' => $aProductos,
                'aCajas' => $aCajas,
            ]);
        }
    }

    /**
     * Updates an existing DmMermas model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $aCajas = DmCajas::getAll();
        $aProductos = \yii\helpers\ArrayHelper::map( DmProductos::find()->all(), 'dm_id_producto', 'dm_nom_producto' );
        $iSaldoAnterior = $model->merma_cantidad;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $oModelProd = DmProductos::findOne( $model->dm_productos_id );
            //cargo saldo anterior al producto

            $oModelProd->dm_stock += $iSaldoAnterior;
            $oModelProd->save();
            //descuento stock del producto
            
            $oModelProd->dm_stock = $oModelProd->dm_stock - $model->merma_cantidad;
            $oModelProd->save();


            return $this->redirect(['view', 'id' => $model->merma_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'aProductos' => $aProductos,
                'aCajas' => $aCajas,
            ]);
        }
    }

    /**
     * Deletes an existing DmMermas model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {

        $model = DmMermas::findOne($id);    

        $oModelProd = DmProductos::findOne( $model->dm_productos_id );
        $oModelProd->dm_stock += $model->merma_cantidad;
        $oModelProd->save();

        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

		/**
		 * Function to find product in select 
		 * @param int $id
		 */
    public function actionFindprod($id){

        $aDataProd = DmProductos::find()
                        ->where( [ 'dm_cajas_id' => $id ] )
                        ->all();


        if ( count( $aDataProd ) ) {
        		echo '<option>--Seleccione--</option>';
            foreach ($aDataProd as $key => $value) {
                echo '<option value="'.$value->dm_id_producto.'" >'.$value->dm_nom_producto.'</option>';
            }
        }
        else {
            echo '<option>NO EXISTEN PRODUCTOS PARA ESTA CAJA</option>';
        }               

    }

    /**
     * Finds the DmMermas model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return DmMermas the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DmMermas::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
