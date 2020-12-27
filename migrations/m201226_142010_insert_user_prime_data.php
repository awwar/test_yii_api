<?php

use app\models\User;
use yii\db\Migration;

/**
 * Class m201226_142010_insert_user_prime_data
 */
class m201226_142010_insert_user_prime_data extends Migration
{
    private $users;

    public function init()
    {
        parent::init();

        $this->users = [
            [
                'id'       => '100',
                'username' => 'admin',
                'email'    => Faker\Factory::create()->email,
                'status'   => User::STATUS_ACTIVE,
                'password' => 'letmein',
            ],
            [
                'id'       => '101',
                'username' => 'demo',
                'email'    => Faker\Factory::create()->email,
                'status'   => User::STATUS_DELETED,
                'password' => 'letmein',
            ],
        ];
    }

    public function safeUp()
    {
        parent::safeUp();

        foreach ($this->users as $user) {
            $ar = new User($user);

            $ar->insert();
        }
    }

    public function safeDown()
    {
        parent::safeDown();
    }
}
