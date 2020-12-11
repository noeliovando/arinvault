<?php

namespace app\models\search;

use app\models\BankName;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\BankAccount;
use yii\helpers\ArrayHelper;

/**
 * BankAccountSearch represents the model behind the search form of `app\models\BankAccount`.
 */
class BankAccountSearch extends BankAccount
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_bank', 'id_person_name', 'id_type_bank_account','id_user'], 'integer'],
            [['number','person_name'], 'safe'],
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
        $query = BankAccount::find();

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
            'id_person_name' => $this->id_person_name,
            'id_type_bank_account' => $this->id_type_bank_account,
            'id_user' => $this->id_user,
        ]);

        $query->andFilterWhere(['like', 'number', $this->number])
            ->andFilterWhere(['like', 'person_name', $this->person_name]);

        return $dataProvider;
    }
    public function getBanks()
    {
        $datos = BankName::find()->asArray()->all();
        return ArrayHelper::map($datos, 'id', 'name');
    }
}
