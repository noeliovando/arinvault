<?php

namespace app\models\search;

use app\models\BankName;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\BankMovil;
use yii\helpers\ArrayHelper;

/**
 * BankMovilSearch represents the model behind the search form of `app\models\BankMovil`.
 */
class BankMovilSearch extends BankMovil
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_bank', 'id_user'], 'integer'],
            [['telefono', 'cedula'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = BankMovil::find();

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
            'id' => $this->id,
            'id_bank' => $this->id_bank,
            'id_user' => $this->id_user,
        ]);

        $query->andFilterWhere(['like', 'telefono', $this->telefono])
            ->andFilterWhere(['like', 'cedula', $this->cedula]);

        return $dataProvider;
    }
    public function getBanks()
    {
        $datos = BankName::find()->asArray()->all();
        return ArrayHelper::map($datos, 'id', 'name');
    }
    public function getUser()
    {
        $datos = User::find()->asArray()->orderBy('username')->all();
        return ArrayHelper::map($datos, 'id', 'username');
    }
}
