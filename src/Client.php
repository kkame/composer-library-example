<?php

declare(strict_types=1);

namespace Kkame\ModernPug;

use GuzzleHttp\RequestOptions;
use Kkame\ModernPug\Exceptions\NotAuthorizedException;
use Psr\Http\Message\ResponseInterface;

class Client
{

    private const API_URL = 'https://modernpug.org/api/v1/recruits';

    private \GuzzleHttp\Client $guzzle;
    private string $authKey;

    public function __construct(\GuzzleHttp\Client $guzzle, string $authKey)
    {
        $this->guzzle = $guzzle;
        $this->authKey = $authKey;
    }

    public function getRecruits(): ResponseInterface
    {
        $response = $this->guzzle->get(self::API_URL, [
            RequestOptions::HEADERS => [
                "Authorization" => "Bearer ".$this->authKey,
            ],
            RequestOptions::ALLOW_REDIRECTS => false, // 인증에 실패한 경우 login 페이지로 redirect 되는 것을 끈다
        ]);

        if ($response->getStatusCode() !== 200) {
            throw new NotAuthorizedException();
        }

        return $response;
    }
}