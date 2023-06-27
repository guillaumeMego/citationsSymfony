<?php 

namespace App\Controller;

use App\Repository\AuteursRepository;
use App\Repository\CitationsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
    #[Route('/api/citations', name: 'api', methods: ['GET'])]
    public function index(CitationsRepository $repository,
    AuteursRepository $auteursRepository): JsonResponse
    {
        $citations = $repository->findAll();
        $auteursRepository->findAll();
        
        $data = [];

        foreach ($citations as $citation) {
            $data[] = [
                'id' => $citation->getId(),
                'citation' => $citation->getCitation(),
                'Explication' => $citation->getExplication(),
                'date' => $citation->getDateModif(),
                'auteur' => ($citation->getAuteurs() !== null) ? [
                    'id' => $citation->getAuteurs()->getId(),
                    'Auteur' => $citation->getAuteurs()->getAuteur(),
                    'Bio' => $citation->getAuteurs()->getBio(),
                ] : null,
            ];
        }
        // CORS
        $response = new JsonResponse($data);
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
        
    }
}
