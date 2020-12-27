<?php

namespace app\components\request_parsers;

use yii\web\RequestParserInterface;

class DummyRequestParser implements RequestParserInterface
{
    public function parse($rawBody, $contentType)
    {
        $parsedBody = [];

        mb_parse_str($rawBody, $parsedBody);

        return $parsedBody;
    }
}