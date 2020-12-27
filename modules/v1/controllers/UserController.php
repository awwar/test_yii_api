<?php

namespace app\modules\v1\controllers;

use app\modules\v1\resources\UserResource;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\ActiveController;
use yii\web\Response;

class UserController extends ActiveController
{
    public $modelClass = UserResource::class;

    public $updateScenario = UserResource::SCENARIO_UPDATE;

    public $createScenario = UserResource::SCENARIO_CREATE;

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['authenticator'] = [
            'class'       => CompositeAuth::class,
            'authMethods' => [
                HttpBearerAuth::class,
            ],
        ];

        $behaviors['contentNegotiator']['formats'] = [
            'application/json' => Response::FORMAT_JSON,
        ];

        return $behaviors;
    }

    protected function verbs()
    {
        return [
            'view'   => ['GET', 'HEAD'],
            'create' => ['POST'],
            'update' => ['PUT'],
            'delete' => ['DELETE'],
        ];
    }
}
