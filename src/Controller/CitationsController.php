<?php

namespace App\Controller;

use App\Entity\Citations;
use App\Form\CitationsType;
use App\Repository\CitationsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CitationsController extends AbstractController
{
    /**
     * Affiche la liste des citations
     * 
     * @param CitationsRepository $repository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     * 
     */
    #[Route('/citations', name: 'citations', methods: ['GET'])]

    public function index(CitationsRepository $repository,
    PaginatorInterface $paginator,
    Request $request): Response
    {

        $citations = $paginator->paginate(
            $repository->findAll(),
            $request->query->getInt('page', 1),
            10
        );
       

        return $this->render('pages/citations/index.html.twig', [
            'citations' => $citations,
        ]);
    }

     /**
     * Methode qui ajoute une citation
     * 
     * @param Auteurs $ingredient
     * @return Response
     */
    #[Route('/citations/nouveau', name: 'citations.new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        EntityManagerInterface $manager
    ): Response {
        $citations = new Citations();
        $form = $this->createForm(CitationsType::class, $citations);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $manager->persist($citations);
            $manager->flush();

            $this->addFlash(
                'success',
                "La citation a bien été ajoutée !"
            );

            return $this->redirectToRoute('citations');
        }

        return $this->render('pages/citations/new.html.twig', [
            'citations' => $citations,
            'form' => $form->createView()
        ]);
    }

    /**
     * Methode qui modifie une citation
     * 
     * @param Citations $citations
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[Route('/citations/edition/{id}', name: 'citations.edit', methods: ['GET', 'POST'])]
    public function edit(
        CitationsRepository $repository, 
        int $id,
        Request $request,
        EntityManagerInterface $manager
    ): Response {
        $citations = $repository->find($id);
        $form = $this->createForm(CitationsType::class, $citations);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $manager->persist($citations);
            $manager->flush();

            $this->addFlash(
                'success',
                "La citation a bien été modifiée !"
            );

            return $this->redirectToRoute('citations');
        }

        return $this->render('pages/citations/edit.html.twig', [
            'citations' => $citations,
            'form' => $form->createView()
        ]);
    }

    /**
     * Methode qui supprime une citation
     * 
     * @param Citations $citations
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[Route('/citations/suppression/{id}', name: 'citations.delete', methods: ['GET'])]
    public function delete(
        CitationsRepository $repository, 
        int $id,
        EntityManagerInterface $manager
    ): Response {
        $citations = $repository->find($id);
        $manager->remove($citations);
        $manager->flush();

        $this->addFlash(
            'success',
            "La citation a bien été supprimée !"
        );

        return $this->redirectToRoute('citations');
    }
}
