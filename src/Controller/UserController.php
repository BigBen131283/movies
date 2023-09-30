<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user')]
class UserController extends AbstractController
{
    
    #[Route('/register', name: 'add.user')]
    public function createUser(
        EntityManagerInterface $entityManager,
        Request $request,
        UserPasswordHasherInterface $userPasswordHasher
    ): Response
    {
        /** @var UserRepository $repository */
        
        $user = new User();
        $new = 1;
        
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $user
            ->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('password')->getData()
                )
            )
            ->setRoles(['ROLE_USER']);

            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('login');

        }elseif($form->isSubmitted() && !$form->isValid()){
            return $this->render('user/index.html.twig', [
                'user' => $user,
                'formuser' => $form->createView(),
                'new' => $new
            ]);
        }else{
            return $this->render('user/index.html.twig', [
                'formuser' => $form->createView(),
                'new' => $new
            ]);
        }
    }
    
    #[Route('/edit/{id}', name: 'edit.user')]
    public function editUser(
        int $id,
        EntityManagerInterface $entityManager,
        Request $request,
    ): Response
    {
        /** @var UserRepository $repository */

        $repository = $entityManager->getRepository(User::class);
        $user = $repository->find($id);
        $new = 2;

        $form = $this->createForm(UserType::class, $user, ['is_register_form' => false]);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $entityManager->persist($user);
            $entityManager->flush();
            $new = 0;

            return $this->render('user/profile.html.twig', [
                'user' => $user,
                'new' => $new
            ]);

        }elseif($form->isSubmitted() && !$form->isValid()){
            $new = 2;
            return $this->render('user/index.html.twig', [
                'user' => $user,
                'formuser' => $form->createView(),
                'new' => $new
            ]);
        }else{
            $new = 2;
            return $this->render('user/index.html.twig', [
                'user' => $user,
                'formuser' => $form->createView(),
                'new' => $new
            ]);
        }
        
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
    
    #[Route('/delete/{id}', name: 'delete.user')]
    public function deleteUser(
        int $id,
        EntityManagerInterface $entityManager,
        SecurityController $security
    ): Response
    {
        /** @var UserRepository $repository */
        $repository = $entityManager->getRepository(User::class);
        $user = $repository->find($id);
        $repository->remove($user, true);
        $security->logout();
        
        return $this->redirectToRoute('home');
    }

    #[Route('/{id}', name: 'profile.user')]
    public function myProfile(
        int $id,
        EntityManagerInterface $entityManager
    ): Response
    {
        /** @var UserRepository $repository */
        $repository = $entityManager->getRepository(User::class);
        $user = $repository->find($id);

        $new = 0;
        
        return $this->render('user/profile.html.twig', [
            'user' => $user,
            'new' => $new
        ]);
    }

    #[Route('/{id}/ma-liste', name: 'userlist')]
    public function myList(
        int $id,
        EntityManagerInterface $entityManager,
        Request $request
    ): Response
    {
        /** @var UserRepository $repository */

        $repository = $entityManager->getRepository(User::class);
        $user = $repository->find($id);
        $form = $this->createForm(UserType::class, $user, ['is_movieslist_form' => true]);
        $form->handleRequest($request);
        $new = 0;

        if($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($user);
            $entityManager->flush();
            $new = 0;
            return $this->render('user/profile.html.twig', [
                'new' => $new,
                'user' => $user,
            ]);
        }elseif($form->isSubmitted() && !$form->isValid()){
            $new = 1;
            return $this->render('user/profile.html.twig', [
                'new' => $new,
                'user' => $user,
                'formuser' => $form->createView(),
            ]);
        }else{
            $new = 1;
            return $this->render('user/profile.html.twig', [
                'formuser' => $form->createView(),
                'user' => $user,
                'new' => $new
            ]);
        }
    }
}
