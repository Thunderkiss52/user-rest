<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class DebugController extends AbstractController
{
    #[Route('/debug', name: 'app_debug')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/DebugController.php',
        ]);
    }

    #[Route('/api/login_check', name: 'api_login_check', methods: ['POST'])]
    public function loginCheck(): Response
    {
        $file = fopen("example.txt", "w"); // Создаем файл с именем example.txt в режиме записи
        fwrite($file, "Привет, мир!"); // Записываем текст в файл
        fclose($file); // Закрываем файл
        return new Response('Debug route works!');
    }

}