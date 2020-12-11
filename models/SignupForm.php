<?php
/**
 * Created by: Noeli Ovando
 * Date: 19/08/2019
 * Time: 04:10 PM
 */

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * Signup form
 */
class SignupForm extends Model
{

    public $username;
    public $email;
    public $password;
    public $name;
    public $surname;
    public $cedula;
    public $id_user_rol;
    public $create_date;
    public $telefono;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required', 'message'=>'El usuario no puede estar en blanco'],
            ['username', 'unique', 'targetClass' => '\app\models\User', 'message' => 'Este usuario ya existe.'],
            ['username', 'string', 'min' => 2, 'max' => 255],
            ['email', 'trim'],
            ['email', 'required', 'message'=>'El email no puede estar en blanco'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\app\models\User', 'message' => 'Este email ya existe.'],
            ['password', 'required', 'message'=>'La contraseña no puede estar en blanco'],
            ['password', 'string', 'min' => 6],
            ['name', 'trim'],
            ['name', 'required', 'message'=>'El nombre no puede estar en blanco'],
            ['name', 'string', 'min' => 2, 'max' => 255],
            ['surname', 'trim'],
            ['surname', 'required', 'message'=>'El apellido no puede estar en blanco'],
            ['surname', 'string', 'min' => 2, 'max' => 255],
            ['cedula', 'trim'],
            ['cedula', 'unique', 'targetClass' => '\app\models\User', 'message' => 'Esta cédula ya existe.'],
            ['cedula', 'required', 'message'=>'La cédula no puede estar en blanco'],
            ['cedula', 'number', 'min' => 123, 'max' => 100000000],
            ['id_user_rol', 'number', 'min' => 123, 'max' => 100000000],
            ['telefono', 'trim'],
            ['telefono', 'required', 'message'=>'El campo no puede estar en blanco'],
            ['telefono', 'string', 'max' => 255],

        ];
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Usuario',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'Correo',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'id_user_rol' => 'Id User Rol',
            'name' => 'Nombre',
            'surname' => 'Apellido',
            'cedula' => 'Cédula',
            'telefono' => 'Telefono/Celular',
        ];
    }
    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {

        if (!$this->validate()) {
            return null;
        }
        date_default_timezone_set("America/Caracas");
        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->name = $this->name;
        $user->surname = $this->surname;
        $user->cedula = $this->cedula;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->id_user_rol = 3;
        $user->create_date = date('Y-m-d h:i:sa');
        $user->telefono = $this->telefono;
        return $user->save() ? $user : null;
    }

}