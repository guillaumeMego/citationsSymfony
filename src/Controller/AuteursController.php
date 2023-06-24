<?php

namespace App\Controller;

use App\Entity\Auteurs;
use App\Form\AuteursType;
use App\Repository\AuteursRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class AuteursController extends AbstractController
{
    /**
     * Metgod qui affiche la liste des auteurs
     * 
     * @param AuteursRepository $repository
     * @return Response
     * @return PaginatorInterface
     * @return Request
     */
    #[Route('/auteur', name: 'auteur', methods: ['GET'])]
    public function index(AuteursRepository $repository,
    PaginatorInterface $paginator,
    Request $request): Response
    {

        $auteurs = $paginator->paginate(
            $repository->findAll(),
            $request->query->getInt('page', 1),
            10
        );
        
        return $this->render('pages/auteurs/index.html.twig', [
            'auteurs' => $auteurs,
        ]);
    }

    /**
     * Methode qui ajoute un ingredient
     * 
     * @param Auteurs $ingredient
     * @return Response
     */
    #[Route('/auteur/nouveau', name: 'auteur.new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        EntityManagerInterface $manager
    ): Response {
        $auteurs = new Auteurs();
        $form = $this->createForm(AuteursType::class, $auteurs);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $ingredient = $form->getData();
            $manager->persist($ingredient);
            $manager->flush();

            $this->addFlash(
                'success',
                "L'auteur a bien été enregistré !"
            );

            return $this->redirectToRoute('auteur');
        };

        return $this->render('pages/auteurs/new.html.twig', [
            'auteurs' => $auteurs,
            'form' => $form->createView()
        ]);
    }

    /**
     * Methode qui modifie un ingredient
     * 
     * @param Ingredient $ingredient
     * @return Response
     */
    #[Route('/auteur/edition/{id}', name: 'auteur.edit', methods: ['GET', 'POST'])]
    public function edit(
        AuteursRepository $repository, 
        int $id,
        Request $request,
        EntityManagerInterface $manager
    ): Response {
        $auteurs = $repository->find($id);
        $form = $this->createForm(AuteursType::class, $auteurs);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $ingredient = $form->getData();
            $manager->persist($ingredient);
            $manager->flush();

            $this->addFlash(
                'success',
                "L'auteur a bien été modifié !"
            );

            return $this->redirectToRoute('auteur');
        };

        return $this->render('pages/auteurs/edit.html.twig', [
            'auteurs' => $auteurs,
            'form' => $form->createView()
        ]);
    }

    /**
     * Methode qui supprime un ingredient
     * 
     * @param Ingredient $ingredient
     * @return Response
     */
    #[Route('/auteur/{id}/delete', name: 'auteur.delete', methods: ['GET'])]
    public function delete(
        AuteursRepository $repository, 
        int $id,
        EntityManagerInterface $manager
    ): Response {
        $auteurs = $repository->find($id);
        $manager->remove($auteurs);
        $manager->flush();

        $this->addFlash(
            'success',
            "L'auteur a bien été supprimé !"
        );

        return $this->redirectToRoute('auteur');
    }
}
