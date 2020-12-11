<?php

namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\helpers\ArrayHelper;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 * @property intenger $id_user_rol
 * @property string $name
 * @property string $surname
 * @property string $cedula
 * @property string $create_date
 * @property string telefono
 *
 * @property BankAccount[] $bankAccounts
 * @property Request[] $requests
 * @property UserRol $userRol
 
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;
    public $password;
    public $password_repeat;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
            [['username',  'email', ], 'required'],
            [['status', 'created_at', 'updated_at', 'id_user_rol'], 'integer'],
            [['username', 'password_hash', 'password_reset_token', 'email', 'telefono'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['username'], 'unique'],
            [['email'], 'unique'],
            [['password_reset_token'], 'unique'],
            ['password', 'required','message' => 'No puede estar en blanco.'],
            ['password', 'string', 'min' => 6],
            ['password_repeat', 'compare', 'compareAttribute'=>'password', 'skipOnEmpty' => false, 'message'=>"Contraseña no coincide"],
            [['id_user_rol'], 'exist', 'skipOnError' => true, 'targetClass' => UserRol::className(), 'targetAttribute' => ['id_user_rol' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBankAccounts()
    {
        return $this->hasMany(BankAccount::className(), ['id_user' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRequests()
    {
        return $this->hasMany(Request::className(), ['id_user' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserRol()
    {
        return $this->hasOne(UserRol::className(), ['id' => 'id_user_rol']);
    }

    public function getUserRols()
    {
        $datos = UserRol::find()
            ->asArray()
            ->all();
        return ArrayHelper::map($datos, 'id', 'name');
    }
    public function nombreCompleto()
    {
        return $this->name? $this->name.' '.$this->surname:'';
    }
    public function getTransactionIn($id_user)
    {
        $count = Transaction::find()
            ->andwhere(['id_user'=> $id_user])
            ->andwhere(['id_trans_type' => 1])
            ->sum('amount');
        return $count? Yii::$app->formatter->asDecimal($count,8): '0';
    }
    public function getTransactionOut($id_user)
    {
        $count = Transaction::find()
            ->andwhere(['id_user'=> $id_user])
            ->andwhere(['id_trans_type' => 2])
            ->sum('amount');
        return $count? Yii::$app->formatter->asDecimal($count,8): '0';
    }
    public static function getBalance($id_user){
        $in = Transaction::find()
            ->andwhere(['id_user'=> $id_user])
            ->andwhere(['id_trans_type' => 1])
            ->sum('amount');
        $out = Transaction::find()
            ->andwhere(['id_user'=> $id_user])
            ->andwhere(['id_trans_type' => 2])
            ->sum('amount');
        return $in - $out;
    }
    public static function  getTasaBs(){
        $datos = TasaDia::find()
            ->orderBy(['id'=>SORT_DESC])
            ->one();
        return ArrayHelper::getValue($datos, 'valor_bolivar');
    }
    public static function  getTasaDolares(){
        $datos = TasaDia::find()
            ->orderBy(['id'=>SORT_DESC])
            ->one();
        return ArrayHelper::getValue($datos, 'valor_dolar');
    }
    public function setPasswordModel()
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($this->password);
    }
    public function setPasswordHasch()
    {
        $this->password_hash = $this->password_hash;
    }

}