<?php

declare(strict_types=1);

namespace App\Util\Serialize;

use App\Exception\DeserializeException;
use Exception;
use App\Util\Enum\StatusHttp;
use App\Exception\SerializeException;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\Serializer;

class SerializeUtil
{
    /**
     * @var Serializer
     */
    protected $jms;

    public function __construct(Serializer $jms)
    {
        $this->jms = $jms;
    }

    /**
     * Método de serializar
     * @throws Exception
     */
    public function serialize($body, $type, $context = null)
    {
        try {
            return $this->jms->serialize($body, $type, $context);
        } catch (Exception $e) {
            throw new SerializeException(
                StatusHttp::INTERNAL_SERVER_ERROR,
                "Erro ao retornar resposta da requisição!",
                $e->getMessage()
            );
        }
    }

    /**
     * Método de deserializar
     * @throws Exception
     */
    public function deserialize($body, $class, $type)
    {
        try {
            return $this->jms->deserialize($body, $class, $type);
        } catch (Exception $e) {
            throw new DeserializeException(
                StatusHttp::BAD_REQUEST,
                "Formato incorreto de dados!",
                $e->getMessage()
            );
        }
    }

    /**
     * @param $objectFrom
     * @param $objectTo
     * @return mixed
     * @throws Exception
     */
    public function reserialize($objectFrom, $objectTo)
    {
        $context = new SerializationContext();
        $context->setSerializeNull(true);
        $contents = $this->serialize($objectFrom, 'json', $context);
        return $this->deserialize($contents, $objectTo, 'json');
    }
}
