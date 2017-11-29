<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\DmMermas;

/**
 * DmMermasS represents the model behind the search form about `app\models\DmMermas`.
 */
class DmMermasS extends DmMermas
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['merma_id', 'merma_cantidad', 'dm_productos_id', 'dm_cajas_id'], 'integer'],
            [['merma_datetime', 'merma_descripcion'], 'safe'],
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
        $query = DmMermas::find();

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
            'merma_id' => $this->merma_id,
            'merma_cantidad' => $this->merma_cantidad,
            'merma_datetime' => $this->merma_datetime,
            'dm_productos_id' => $this->dm_productos_id,
            'dm_cajas_id' => $this->dm_cajas_id,
        ]);

        $query->andFilterWhere(['like', 'merma_descripcion', $this->merma_descripcion]);

        return $dataProvider;
    }
}
