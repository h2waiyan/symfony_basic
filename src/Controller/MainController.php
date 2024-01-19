<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @return Response
     */
    #[Route('/', name: 'home')]
    public function index(): Response
    {
        return $this->render(view: 'home/index.html.twig');
    }

    /**
     * @param Request $request
     * @return Response
     */
    #[Route('/custom/{name}', name: 'custom')]
    public function custom(Request $request): Response
    {
        $name = $request->get('name');
        return $this->render(view: 'home/custom.html.twig', parameters: [
            'name' => $name
        ]);
    }
}
