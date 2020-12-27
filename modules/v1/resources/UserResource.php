<?php

namespace app\modules\v1\resources;

use app\models\User;
use yii\db\Query;

class UserResource extends User
{
    public const SCENARIO_UPDATE = 'update';

    public const SCENARIO_CREATE = 'create';

    private const ERROR_INVALID_USERNAME = 'Username must mach following pattern: [A-z0-9_-]';

    public function rules()
    {
        return [
            [['email', 'username', 'password'], 'required', 'on' => static::SCENARIO_CREATE],
            ['password', 'string', 'min' => 6],
            ['username', 'string', 'max' => 64, 'min' => 2],
            ['username', 'match', 'pattern' => '/^[A-z0-9_-]*$/i', 'message' => self::ERROR_INVALID_USERNAME],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
            ['email', 'email'],
            [
                ['email', 'username'],
                'unique',
                'targetClass' => User::class,
                'filter'      => function (Query $query) {
                    $query->andFilterWhere(['not', ['id' => $this->id]]);
                },
            ],
        ];
    }

    public function fields()
    {
        return [
            'id',
            'email',
            'username',
        ];
    }

    public function scenarios()
    {
        return [
            self::SCENARIO_UPDATE => ['username', 'email', 'password'],
            self::SCENARIO_CREATE => ['username', 'email', 'password'],
        ];
    }

    public function delete()
    {
        $this->status = self::STATUS_DELETED;

        return self::update(false);
    }
}