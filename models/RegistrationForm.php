<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * RegistrationForm is the model behind the register form.
 */
class RegistrationForm extends Model 
{
    public $username;
    public $email;
    public $password;
    public $password_repeat;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // Обязательно ввечти
            [['username', 'email', 'password', 'password_repeat'], 'required'],
            //убрать пробелы
            [['username', 'email', 'password', 'password_repeat'], 'trim'],
            // сравнение паролей
            ['password', 'compare'],
            //проверка правильности
            ['email', 'email'],
            //проверка на уникальность
            // [['username', 'email'], 'unique', 'targetAttribute' => ['username', 'email']]
        ];
    }

    /**
     * Registers a user using the provided params. 
     * @return bool whether the user is registered successfully
     */
    public function register()
    {
        if ($this->validate()) {
            $user = new User();
            $user->username = $this->username;
            $user->email = $this->email;
            $user->password_hash = Yii::$app->getSecurity()->generatePasswordHash($this->password);
            $user->auth_key = Yii::$app->getSecurity()->generateRandomString();
            $current_time = time();
            $user->created_at = $current_time;
            $user->updated_at = $current_time;
            $user->access_token = Yii::$app->getSecurity()->generateRandomString();
            $user->save();

            return true;
        }

        return false;
    }
}