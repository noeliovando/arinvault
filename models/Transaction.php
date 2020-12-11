<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "transaction".
 *
 * @property int $id
 * @property int $id_user
 * @property string $description
 * @property string $date
 * @property string $amount
 * @property int $id_trans_type
 *
 * @property TransType $transType
 * @property User $user
 */
class Transaction extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'transaction';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_user', 'description', 'date', 'amount', 'id_trans_type'], 'required'],
            [['id_user', 'id_trans_type'], 'integer'],
            [['date'], 'safe'],
            [['amount'], 'number'],
            [['description'], 'string', 'max' => 500],
            [['id_trans_type'], 'exist', 'skipOnError' => true, 'targetClass' => TransType::className(), 'targetAttribute' => ['id_trans_type' => 'id']],
            [['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['id_user' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_user' => 'Usuario',
            'description' => 'Descripción',
            'date' => 'Fecha',
            'amount' => 'Cantidad BTC',
            'id_trans_type' => 'Tipo de Transacción',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransType()
    {
        return $this->hasOne(TransType::className(), ['id' => 'id_trans_type']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'id_user']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransactionIn($id_user)
    {
        $count = $this::find()
            ->andwhere(['id_user'=> $id_user])
            ->andwhere(['id_trans_type' => 1])
            ->sum('amount');
        return $count? Yii::$app->formatter->asDecimal($count,8): '0';
    }
    public function getTransactionOut($id_user)
    {
        $count = $this::find()
            ->andwhere(['id_user'=> $id_user])
            ->andwhere(['id_trans_type' => 2])
            ->sum('amount');
        return $count? Yii::$app->formatter->asDecimal($count,8): '0';
    }
    public function getBalance(){
        return $this->getTransactionIn(Yii::$app->user->identity->id) - $this->getTransactionOut(Yii::$app->user->identity->id);
    }
    public function getTotalBalance(){
        $in = Transaction::find()
            ->andwhere(['id_trans_type' => 1])
            ->sum('amount');
        $out = Transaction::find()
            ->andwhere(['id_trans_type' => 2])
            ->sum('amount');
        return $in - $out;
    }
    public function getUserName()
    {
        return $this->user? $this->user->name.' '.$this->user->surname: 'Vacio';
    }
    public function getTransTypeName()
    {
        return $this->transType? $this->transType->type: 'Vacio';
    }
    public function getUsers()
    {
        $datos = User::find()
            ->asArray()
            ->orderBy('username')
            ->all();
        return ArrayHelper::map($datos, 'id', 'username');
    }
    public function getTypeTrans()
    {
        $datos = TransType::find()
            ->asArray()
            ->all();
        return ArrayHelper::map($datos, 'id', 'type');
    }
    public function  getTasaBs(){
        $datos = TasaDia::find()
            ->orderBy(['id'=>SORT_DESC])
            ->one();
        return ArrayHelper::getValue($datos, 'valor_bolivar');
    }
    public function  getTasaDolares(){
        $datos = TasaDia::find()
            ->orderBy(['id'=>SORT_DESC])
            ->one();
        return ArrayHelper::getValue($datos, 'valor_dolar');
    }

}
