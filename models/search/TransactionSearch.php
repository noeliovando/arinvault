<?php

namespace app\models\search;

use app\models\RequestType;
use app\models\User;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Transaction;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * TransactionSearch represents the model behind the search form of `app\models\Transaction`.
 */
class TransactionSearch extends Transaction
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_user', 'id_trans_type'], 'integer'],
            [['description', 'date'], 'safe'],
            [['amount'], 'number'],
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
        $query = Transaction::find();

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
        if(Yii::$app->user->identity->id_user_rol=='1')
            $query->andFilterWhere([
                'id' => $this->id,
                'id_user' => $this->id_user,
                'date' => $this->date,
                'amount' => $this->amount,
                'id_trans_type' => $this->id_trans_type,
            ]);
        if(Yii::$app->user->identity->id_user_rol=='2')
            $query->andFilterWhere([
                'id' => $this->id,
                'id_user' => Yii::$app->user->identity->id,
                'date' => $this->date,
                'amount' => $this->amount,
                'id_trans_type' => $this->id_trans_type,
            ]);

        $query->andFilterWhere(['like', 'description', $this->description])->orderBy(['date' => SORT_DESC,'id' => SORT_DESC]);

        return $dataProvider;
    }
    public function getUser()
    {
        $datos = User::find()->asArray()->orderBy('username')->all();
        return ArrayHelper::map($datos, 'id', 'username');
    }
    public function getTransType()
    {
        $datos = RequestType::find()->asArray()->all();
        return ArrayHelper::map($datos, 'id', 'name');
    }
}
