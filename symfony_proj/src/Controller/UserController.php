<?php

namespace App\Controller;

use App\Meta\Vo\Result;
use App\Model\Enums\TimeUnit;
use App\Service\UserService;
use http\Exception\RuntimeException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    static private $LIVE_TIME = 1;

    public function __construct(private UserService $userService) {
        if ($userService === null) {
            throw new RuntimeException("UserService should not be null.");
        }
    }

    #[Route('/user/{id}', name: 'user_show')]
    public function getUserInfo(int $id) : Response {
        $user = $this->userService->getCachedInfo(
            [
                'id' => $id
            ],
            static::$LIVE_TIME,
            TimeUnit::DAY
        );
        if (!$user) {
            $result = Result::error(Result::RESULT_CODE_ERR, 'The user is not found.', ['id' => $id]);
            return new Response(json_encode($result));
        }
        $result = Result::ok($user);
        return new Response($result);
    }
}