<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\DmVentas;

/**
 * DmVentaSearch represents the model behind the search form about `app\models\DmVentas`.
 */
class DmVentaSearch extends DmVentas
{

    public $dm_nom_producto;
    public $dm_codigo;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['dm_venta_id', 'dm_venta_cantidad', 'dm_productos_dm_id_producto', 'dm_venta_diario_dm_venta_diario_id'], 'integer'],
        ];
    }


    public function attributeLabels(){
        return [
            'dm_nom_producto' => 'Producto',
            'dm_codigo' => 'Código de producto'
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = DmVentas::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'dm_venta_id' => $this->dm_venta_id,
            'dm_venta_cantidad' => $this->dm_venta_cantidad,
            'dm_productos_dm_id_producto' => $this->dm_productos_dm_id_producto,
            'dm_venta_diario_dm_venta_diario_id' => $this->dm_venta_diario_dm_venta_diario_id,
        ]);

        return $dataProvider;
    }




    /**
     * Function search
     * @param  array $params [description]
     * @return dataProvider 
     */
    public function searchProducto( $params ){

        $query = DmProductos::find();

        //$this->load( $params );

        $dataProvider = new ActiveDataProvider([
                'query' => $query,
            ]);


        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        
        $query->andFilterWhere( ['or' ,
                    [ 'like', 'dm_codigo' , $params['dm_nom_producto']],
                    [ 'like', 'dm_nom_producto' , $params['dm_nom_producto']]
                ]);
        
        $query->andFilterWhere( [ '>', 'dm_stock', 0 ] );

        return $dataProvider;
    }
}
