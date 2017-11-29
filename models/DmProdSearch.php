<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\DmProductos;

/**
 * DmProdSearch represents the model behind the search form about `app\models\DmProductos`.
 */
class DmProdSearch extends DmProductos
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['dm_id_producto', 'dm_stock_min_compras', 'dm_stock', 'dm_precio_compra', 'dm_precio_venta', 'dm_cajas_id'], 'integer'],
            [['dm_codigo', 'dm_nom_producto'], 'safe'],
            [['dm_porcentaje_ganancia'], 'number'],
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
        $query = DmProductos::find();

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
            'dm_id_producto' => $this->dm_id_producto,
            'dm_stock_min_compras' => $this->dm_stock_min_compras,
            'dm_stock' => $this->dm_stock,
            'dm_precio_compra' => $this->dm_precio_compra,
            'dm_porcentaje_ganancia' => $this->dm_porcentaje_ganancia,
            'dm_precio_venta' => $this->dm_precio_venta,
            'dm_cajas_id' => $this->dm_cajas_id,
        ]);

        $query->andFilterWhere(['like', 'dm_codigo', $this->dm_codigo])
            ->andFilterWhere(['like', 'dm_nom_producto', $this->dm_nom_producto]);

        return $dataProvider;
    }
}
