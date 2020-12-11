<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\UserAccount;
use yii\helpers\ArrayHelper;
use app\models\User;

/**
 * UserAccountSearch represents the model behind the search form of `app\models\UserAccount`.
 */
class UserAccountSearch extends UserAccount
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_user'], 'integer'],
            [['btc_amount'], 'number'],
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
        $query = UserAccount::find();

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
            'id_user' => $this->id_user,
            'btc_amount' => $this->btc_amount,
        ])
            ->joinWith('user')
        ->orderBy('user.username');

        return $dataProvider;
    }
    public function getUser()
    {
        $datos = User::find()->andwhere(['id_user_rol' =>'2' ])->all();
        return ArrayHelper::map($datos, 'id', 'username');
    }
}
