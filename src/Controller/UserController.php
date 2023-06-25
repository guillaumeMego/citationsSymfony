<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    /**
     * Affiche la liste des utilisateurs
     * 
     * @param UserRepository $repository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     * 
     */
    #[Route('/utilisateurs', name: 'user', methods: ['GET'])]
    public function index(UserRepository $repository,
    PaginatorInterface $paginator,
    Request $request
    ): Response
    {
        $users = $paginator->paginate(
            $repository->findAll(),
            $request->query->getInt('page', 1),
            10
        );


        return $this->render('pages/user/index.html.twig', [
            'users' => $users,
        ]);
    }

    /**
     * Methode qui ajoute un utilisateur
     * 
     * @param Auteurs $ingredient
     * @return Response
     */
    #[Route('/utilisateurs/nouveau', name: 'users.new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        EntityManagerInterface $manager
    ): Response {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            dd($data);
            $manager->persist($user);
            $manager->flush();

            $this->addFlash('success', 'L\'utilisateur a bien été ajouté');

            return $this->redirectToRoute('user');
        }
        return $this->render('pages/user/new.html.twig', [
            'users' => $user,
            'form' => $form->createView()
        ]);
    }
    
}
