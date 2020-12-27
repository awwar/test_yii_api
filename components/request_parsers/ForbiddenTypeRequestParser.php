<?php

namespace app\components\request_parsers;

use yii\web\BadRequestHttpException;
use yii\web\RequestParserInterface;

class ForbiddenTypeRequestParser implements RequestParserInterface
{
    public function parse($rawBody, $contentType)
    {
        throw new BadRequestHttpException('Forbidden content type: ' . $contentType);
    }
}