<?php

declare(strict_types=1);

namespace App\Service\Response;

use Laminas\Diactoros\Stream;
use Laminas\Diactoros\Response;
use App\DTO\Response\ResponseData;
use App\DTO\Response\ResponseError;
use App\Util\Serialize\SerializeUtil;
use JMS\Serializer\SerializationContext;
use Laminas\Diactoros\Response\InjectContentTypeTrait;

class ApiResponse extends Response
{
    use InjectContentTypeTrait;

    /**
     * @var mixed
     */
    private $container;

    /**
     * @var SerializeUtil
     */
    private $jms;

    public const SUCCESS = 0;
    public const ERROR = 1;

    public function __construct($data, ?int $status, int $type = 0)
    {
        $status = (empty($status) || $status < 100) ? 500 : $status;
        $headers = [];
        $this->container = require 'config/container.php';
        $this->jms = $this->container->get(SerializeUtil::class);
        $headers = $this->injectContentType('application/json', $headers);
        parent::__construct($this->createResponse($data, $status, $type), $status, $headers);
    }

    /**
     * Cria a resposta para o client-side
     *
     * @param $data
     * @param int $status
     * @param int $type
     * @return Stream
     * @throws \Exception
     */
    private function createResponse($data, int $status, int $type = 0): Stream
    {
        $responseData = new ResponseData();
        $responseData->setStatusCode($status);

        if ($type == self::SUCCESS) {
            $responseData->setData($data);
        } else {
            if (!is_array($data)) {
                $error = new ResponseError();
                $error->setMessage("Ocorreu um erro inesperado na aplicação!");
                $error->setInternalMessage($data);
                $error->setInternalCode(-1);
                $data = [$error];
            }
            $responseData->setError($data);
        }

        $context = new SerializationContext();
        $context->setSerializeNull(true);

        $body = new Stream('php://temp', 'wb+');
        $body->write($this->jms->serialize($responseData, 'json', $context));
        $body->rewind();
        return $body;
    }
}
