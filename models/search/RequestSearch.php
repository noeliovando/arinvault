<?php

namespace app\models\search;

use app\models\RequestStatus;
use app\models\User;
use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
use app\models\Request;
use app\models\RequestType;

/**
 * RequestSearch represents the model behind the search form of `app\models\Request`.
 */
class RequestSearch extends Request
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_user', 'id_type_request', 'id_request_status'], 'integer'],
            [['amount'], 'number'],
            [['description', 'date'], 'safe'],
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
        $query = Request::find();

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
            'amount' => $this->amount,
            'date' => $this->date,
            'id_user' => $this->id_user,
            'id_type_request' => $this->id_type_request,
            'id_request_status' => $this->id_request_status,
            'id_request_speed' => $this->id_request_speed,
        ]);
        if(Yii::$app->user->identity->id_user_rol=='2')
            $query->andFilterWhere([
                'id' => $this->id,
                'amount' => $this->amount,
                'date' => $this->date,
                'id_user' => Yii::$app->user->identity->id,
                'id_type_request' => $this->id_type_request,
                'id_request_status' => $this->id_request_status,
                'id_request_speed' => $this->id_request_speed,
            ]);

        $query->andFilterWhere(['like', 'description', $this->description])->orderBy(['date' => SORT_DESC]);

        return $dataProvider;
    }
    public function getTypeRequest()
    {
        $datos = RequestType::find()->asArray()->all();
        return ArrayHelper::map($datos, 'id', 'name');
    }
    public function getUser()
    {
        $datos = User::find()->asArray()->orderBy('username')->all();
        return ArrayHelper::map($datos, 'id', 'username');
    }

    public function getRequestStatus()
    {
        $datos = RequestStatus::find()->asArray()->all();
        return ArrayHelper::map($datos, 'id', 'name');
    }

    
}
