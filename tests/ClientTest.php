<?php

declare(strict_types=1);

namespace Test\ModernPug;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use Kkame\ModernPug\Client;
use Kkame\ModernPug\Exceptions\NotAuthorizedException;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase
{

    /**
     * @test
     */
    public function 만약_인증에_실패했다면_예외를_던진다(): void
    {
        $this->expectException(NotAuthorizedException::class);

        $client = new Client($this->getNotAuthorizedResponseClient(), 'NOT_ALLOWED_KEY');
        $client->getRecruits();
    }

    protected function getNotAuthorizedResponseClient(): \GuzzleHttp\Client
    {
        return new \GuzzleHttp\Client([
            'handler' => new MockHandler([
                new Response(301, [], 'MOCK REDIRECT RESPONSE'),
            ]),
        ]);
    }


    /**
     * @test
     */
    public function 인증에_성공할_경우_객체를_반환(): void
    {
        $client = new Client($this->getSuccessResponseClient(), 'ALLOWED_KEY');
        $recruits = $client->getRecruits();
        $this->assertIsObject($recruits);
    }

    protected function getSuccessResponseClient(): \GuzzleHttp\Client
    {
        return new \GuzzleHttp\Client([
            'handler' => new MockHandler([
                new Response(200, [], file_get_contents(__DIR__.'/stubs/success.json')),
            ]),
        ]);
    }
}
