<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "request".
 *
 * @property int $id
 * @property string $amount
 * @property string $description
 * @property string $date
 * @property int $id_user
 * @property int $id_type_request
 * @property int $id_request_status
 * @property int $id_request_speed
 *
 * @property User $user
 * @property RequestType $typeRequest
 * @property RequestStatus $requestStatus
 * @property RequestSpeed $requestSpeed
 */
class Request extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'request';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [

            [['amount', 'description', 'date', 'id_user', 'id_type_request', 'id_request_status', 'id_request_speed'], 'required'],
            [['amount'], 'number'],
            [['date'], 'safe'],
            [['id_user', 'id_type_request', 'id_request_status', 'id_request_speed'], 'integer'],
            [['description'], 'string', 'max' => 500],
            [['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['id_user' => 'id']],
            [['id_type_request'], 'exist', 'skipOnError' => true, 'targetClass' => RequestType::className(), 'targetAttribute' => ['id_type_request' => 'id']],
            [['id_request_status'], 'exist', 'skipOnError' => true, 'targetClass' => RequestStatus::className(), 'targetAttribute' => ['id_request_status' => 'id']],
            [['id_request_speed'], 'exist', 'skipOnError' => true, 'targetClass' => RequestSpeed::className(), 'targetAttribute' => ['id_request_speed' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'amount' => 'Monto en Bs.',
            'description' => 'Descripción',
            'date' => 'Fecha',
            'id_user' => 'Usuario',
            'id_type_request' => 'Tipo de Soliditud',
            'id_request_status' => 'Estatus de solicitud',
            'id_request_speed' => 'Rapidez de solicitud',
        ];
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
    public function getTypeRequest()
    {
        return $this->hasOne(RequestType::className(), ['id' => 'id_type_request']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRequestStatus()
    {
        return $this->hasOne(RequestStatus::className(), ['id' => 'id_request_status']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRequestSpeed()
    {
        return $this->hasOne(RequestSpeed::className(), ['id' => 'id_request_speed']);
    }

    public function getTypeRequests()
    {
        $datos = RequestType::find()
        ->asArray()
        ->all();
        return ArrayHelper::map($datos, 'id', 'name');
    }

    public function getUsers()
    {
        $datos = User::find()
            ->asArray()
            ->all();
        return ArrayHelper::map($datos, 'id', 'username');
    }

    public function getRequestsSpeeds()
    {
        $datos = RequestSpeed::find()
            ->asArray()
            ->all();
        return ArrayHelper::map($datos, 'id', 'name');
    }

    public function getRequestsStatus()
    {
        $datos = RequestStatus::find()
            ->asArray()
            ->all();
        return ArrayHelper::map($datos, 'id', 'name');
    }

    public function getRequestTypeName()
    {
        return $this->typeRequest? $this->typeRequest->name: 'Vacio';
    }

    public function getUserName()
    {
        return $this->user? $this->user->name.' '.$this->user->surname: 'Vacio';
    }

    public function getRequestStatusName()
    {
        return $this->requestStatus? $this->requestStatus->name: 'Vacio';
    }

}
