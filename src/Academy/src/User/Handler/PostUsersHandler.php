<?php

declare(strict_types=1);

namespace Academy\User\Handler;

use App\Util\Enum\StatusHttp;
use App\Util\Enum\SuccessMessage;
use App\Service\Response\ApiResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class PostUsersHandler implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $body = $request->getAttribute("body");
        var_dump($body);
        exit;
        return new ApiResponse(
            SuccessMessage::SAVED_RECORD,
            StatusHttp::CREATED,
            ApiResponse::SUCCESS
        );
    }
}