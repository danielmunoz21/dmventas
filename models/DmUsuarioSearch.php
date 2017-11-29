<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\DmUsuario;

/**
 * DmUsuarioSearch represents the model behind the search form about `app\models\DmUsuario`.
 */
class DmUsuarioSearch extends DmUsuario
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['dm_usuario_id', 'dm_tipo'], 'integer'],
            [['dm_usuario_nombre', 'dm_usuario_clave'], 'safe'],
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
        $query = DmUsuario::find();

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
            'dm_usuario_id' => $this->dm_usuario_id,
            'dm_tipo' => $this->dm_tipo,
        ]);

        $query->andFilterWhere(['like', 'dm_usuario_nombre', $this->dm_usuario_nombre])
            ->andFilterWhere(['like', 'dm_usuario_clave', $this->dm_usuario_clave]);

        return $dataProvider;
    }
}
