<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class UserController extends AbstractController
{
    #[Route('/Admin/user', name: 'app_user')]
    public function index(UserRepository $userRepository): Response
    {
        $users = $userRepository->findAll();
        return $this->render('user/index.html.twig', [
            'users' => $users
        ]);
    }

    #[Route('/admin/user/{id}/add/editor', name: 'app_user_add_editor_role')]
    public function ediorRoleAdd(User $user, EntityManagerInterface $entityManager ): Response
    {
        $user->setRoles(["ROLE_EDITOR", "ROLE_USER"]);
        $entityManager->flush();

        $this->addFlash('success', 'Le role éditeur a été ajouté à l\'utilisateur');
        return $this->redirectToRoute('app_user');
    }


    #[Route('/admin/user/{id}/remove/editor', name: 'app_user_remove_editor_role')]
    public function ediorRoleRemove(User $user, EntityManagerInterface $entityManager ): Response
    {
        $user->setRoles([]);
        $entityManager->flush();

        $this->addFlash('danger', 'Le role éditeur a été retiré à l\'utilisateur');
        return $this->redirectToRoute('app_user');
    }


        #[Route('/admin/user/{id}/delete', name: 'app_user_delete')]
    public function ediorRoleDelete(User $user, EntityManagerInterface $entityManager ): Response
    {
        $entityManager->remove($user);
        $entityManager->flush();

        $this->addFlash('danger', 'L\'utilisateur a été supprimé');
        return $this->redirectToRoute('app_user');
    }
}
