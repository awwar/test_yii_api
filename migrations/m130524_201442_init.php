<?php

use app\models\User;
use yii\db\Migration;

class m130524_201442_init extends Migration
{
    public function up()
    {
        $this->createTable(
            '{{%user}}',
            [
                'id'                   => $this->primaryKey(),
                'username'             => $this->string()->notNull()->unique(),
                'auth_key'             => $this->string(32)->notNull(),
                'password_hash'        => $this->string()->notNull(),
                'email'                => $this->string()->notNull()->unique(),

                'status'     => $this->smallInteger()->notNull()->defaultValue(User::STATUS_ACTIVE),
                'created_at' => $this->integer()->notNull(),
                'updated_at' => $this->integer()->notNull(),
            ]
        );
    }

    public function down()
    {
        $this->dropTable('{{%user}}');
    }
}
