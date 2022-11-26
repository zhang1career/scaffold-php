<?php

namespace App\Api;

use App\Model\Entity\User;
use App\Util\GraphQL\Condition;
use App\Util\GraphQL\GraphQL;
use App\Util\GraphQL\Source;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class UserApi
{

    public function __construct(private HttpClientInterface $httpClient) {
    }

    public function findOneBy(int $userId) : ?User {

        $fields = ['name'];

        $source = new Source('user');

        $condition = new Condition(
            [
                'id' => $userId
            ]
        );

        $graphql = new GraphQL($fields, $source, $condition);

        $requestJson = json_encode(
            [
                'query' => $graphql
            ],
            JSON_THROW_ON_ERROR
        );

        $response = $this->httpClient->request(
            'POST',
            'http://www.baidu.com/query',
            [
                'headers' => [
                    'Content-Type: application/json',
                    'Accept: application/json',
                ],
                'body' => $requestJson,
                'timeout' => 1
            ]
        );

        if (200 !== $response->getStatusCode()) {
            return null;
        }

        $responseJson = $response->getContent();
        $responseData = json_decode($responseJson, true, 512, JSON_THROW_ON_ERROR);

        $user = new User();
        $user->setId($responseData['id']);
        $user->setName($responseData['name']);
    }
}
