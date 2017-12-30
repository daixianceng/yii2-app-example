<?php
namespace common\rest;

use Yii;
use yii\web\Response;
use yii\web\HttpException;

/**
 * ErrorHandler handles uncaught PHP errors and exceptions.
 *
 * ErrorHandler displays these errors using [[\common\rest\DataInterface]].
 *
 * @author Cosmo<daixianceng@gmail.com>
 */
class ErrorHandler extends \yii\web\ErrorHandler
{
    /**
     * @var string|array the configuration for creating the serializer that formats the response data.
     */
    public $serializer = 'common\rest\Serializer';

    /**
     * @inheritdoc
     */
    protected function renderException($exception)
    {
        $errorData = new ErrorData($this->convertExceptionToArray($exception));

        $response = static::getResponse();
        $response->data = Yii::createObject($this->serializer)->serialize($errorData);

        if ($exception instanceof HttpException) {
            $response->setStatusCode($exception->statusCode);
        } else {
            $response->setStatusCode(500);
        }

        $response->send();
    }

    /**
     * Returns the response component.
     * @return Response the response component.
     */
    protected static function getResponse()
    {
        if (Yii::$app->has('response')) {
            $response = Yii::$app->getResponse();
            // reset parameters of response to avoid interference with partially created response data
            // in case the error occurred while sending the response.
            $response->isSent = false;
            $response->stream = null;
            $response->data = null;
            $response->content = null;
        } else {
            $response = new Response();
        }

        return $response;
    }
}
