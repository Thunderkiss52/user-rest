<?php

namespace App\Controller;

use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[\Symfony\Component\Routing\Attribute\Route('/api')]
final class UserController extends AbstractController
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    #[Route('/register', name: 'api_register', methods: ['POST'])]
    public function register(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        if (!isset($data['email']) || !isset($data['password'])) {
            return $this->json(['error' => 'Email and password are required'], 400);
        }

        try {
            $user = $this->userService->createUser($data['email'], $data['password']);
            return $this->json(['message' => 'User created'], 201);
        } catch (\InvalidArgumentException $e) {
            return $this->json(['error' => $e->getMessage()], 400);
        }
    }

    #[Route('/users/me', name: 'api_user_info', methods: ['GET'])]
    public function getUserInfo(): JsonResponse
    {
        $user = $this->getUser();
        return $this->json(['id' => $user->getId(), 'email' => $user->getEmail()]);
    }

    #[Route('/users/me', name: 'api_user_update', methods: ['PUT'])]
    public function updateUser(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        if (!isset($data['email'])) {
            return $this->json(['error' => 'Email is required'], 400);
        }

        try {
            $user = $this->getUser();
            $this->userService->updateUser($user, $data['email']);
            return $this->json(['message' => 'User updated']);
        } catch (\InvalidArgumentException $e) {
            return $this->json(['error' => $e->getMessage()], 400);
        }
    }

    #[Route('/users/me/password', name: 'api_user_password_update', methods: ['PUT'])]
    public function updatePassword(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        if (!isset($data['password'])) {
            return $this->json(['error' => 'Password is required'], 400);
        }

        try {
            $user = $this->getUser();
            $this->userService->upgradePassword($user, $data['password']);
            return $this->json(['message' => 'Password updated']);
        } catch (\InvalidArgumentException $e) {
            return $this->json(['error' => $e->getMessage()], 400);
        }
    }

    #[Route('/users/me', name: 'api_user_delete', methods: ['DELETE'])]
    public function deleteUser(): JsonResponse
    {
        $user = $this->getUser();
        $this->userService->deleteUser($user);
        return $this->json(['message' => 'User deleted']);
    }
}