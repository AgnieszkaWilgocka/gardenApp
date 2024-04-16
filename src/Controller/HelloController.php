<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HelloController
{
    #[Route('/hello', name:'hello', methods:'GET')]
    public function index(Request $request): Response
    {
        $name = $request->query->getAlnum('name', 'unknown');

        return new Response('Hello' . $name . '!');
        // return new Response('hello');
    }
}

?>