<?php

namespace app\controllers;

use Yii;
use app\models\DmProductos;
use app\models\DmProdSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\DmCajas;
use kartik\mpdf\Pdf;


/**
 * ProductosController implements the CRUD actions for DmProductos model.
 */
class ProductosController extends Controller
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
                'only' => ['create', 'update', 'view', 'delete', 'index', 'stock', 'listado' ],
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
     * Lists all DmProductos models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DmProdSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $aCajas = DmCajas::getAll();
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'aCajas' => $aCajas,
        ]);
    }

    /**
     * Displays a single DmProductos model.
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
     * Creates a new DmProductos model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new DmProductos();

        $aCajas = DmCajas::getAll();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->dm_id_producto]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'aCajas' => $aCajas,
            ]);
        }
    }

    /**
     * Updates an existing DmProductos model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $aCajas = DmCajas::getAll();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->dm_id_producto]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'aCajas' => $aCajas,
            ]);
        }
    }

    /**
     * Deletes an existing DmProductos model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }


    public function actionStock( $id ){
        $model = $this->findModel( $id );
        $iStockAnterior = $model->dm_stock;
        if ( $model->load( Yii::$app->request->post() ) ){
            $model->dm_stock += $iStockAnterior;
            if ( $model->save() ){
                return $this->redirect([ 'view', 'id' => $model->dm_id_producto ]);
            }
        }

        return $this->render( '_stock', [ 'model' => $model ] );
    }


    public function actionListado(){

        $aCajas = DmCajas::getAll();


        $content = $this->renderPartial('_list_format', [ 'aCajas' => $aCajas ]);

        $pdf = new Pdf([
            'mode' => Pdf::MODE_UTF8, // leaner size using standard fonts
            'format' => Pdf::FORMAT_LETTER,
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
            'content' => $content,
            'options' => [
                'title' => 'Listado de Productos',
                'subject' => 'Listado de productos con códigos de barra incluidos'
            ],
            'methods' => [
                'SetHeader' => ['DmVentas: ' . date("r")],
                'SetFooter' => ['|Página {PAGENO}|'],
            ],
            'destination' => Pdf::DEST_BROWSER,
            'filename'=> 'Listado_productos.pdf'
        ]);

        // return the pdf output as per the destination setting
        $pdf->render();

    }


    /**
     * Finds the DmProductos model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return DmProductos the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DmProductos::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
