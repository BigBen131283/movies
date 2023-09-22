<?php

namespace App\Controller;

use App\Entity\Movies;
use App\Form\MoviesType;
use App\Repository\MoviesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/movies')]
class MoviesController extends AbstractController
{
    #[Route('/', name: 'movies')]
    public function index(): Response
    {
        $add = 0;
        return $this->render('movies/index.html.twig', [
            'controller_name' => 'MoviesController',
        ]);
    }

    #[Route('/list', name: 'movies.list')]
    public function allMovies(
        EntityManagerInterface $entityManager,
    ): Response
    {
        $add = 0;
        // la ligne ci-dessous permet de notifier à l'IDE que la variable $repository est un repository. Il peut ensuite proposer les méthodes. 
        /** @var MoviesRepository $repository */
        $repository = $entityManager->getRepository(Movies::class);
        $allMovies = $repository->findAll();
        
        return $this->render('movies/index.html.twig', [
            "movies" => $allMovies,
            "add" => $add
        ]);
    }

    #[Route('/add', name: 'movies.add')]
    public function addMovie(
        EntityManagerInterface $entityManager,
        Request $request
    ): Response
    {
        /** @var MoviesRepository $repository */
        $add = 1;
        $movie = new Movies();
        $repository = $entityManager->getRepository(Movies::class);
        $movies = $repository->findAll();
        $form = $this->createForm(MoviesType::class, $movie);
        $form->handleRequest($request); 
        
        if($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($movie);
            $entityManager->flush();
            return $this->redirectToRoute('movies.list');
        }elseif($form->isSubmitted() && !$form->isValid()){
            $add = 1;
            return $this->render('movies/index.html.twig', [
                'add' => $add,
                'movies' => $movies,
                'formmovie' => $form->createView()
            ]);
        }else{
            return $this->render('movies/index.html.twig', [
                'formmovie' => $form->createView(),
                'movies' => $movies,
                'add' => $add,
            ]);
        }
    }

    #[Route('/delete/{id}', name: 'movies.delete')]
    public function deleteMovie(
        int $id,
        EntityManagerInterface $entityManager
    ): Response
    {
        /** @var MoviesRepository $repository */
        $repository = $entityManager->getRepository(Movies::class);
        $movie = $repository->find($id);
        $repository->remove($movie, true);

        return $this->redirectToRoute('movies.list');
    }
    
    #[Route('/update/{id}', name: 'movies.update')]
    public function updateMovie(
        int $id,
        EntityManagerInterface $entityManager,
        Request $request
    ): Response
    {
        $add = 2;
        $repository = $entityManager->getRepository(Movies::class);
        $movie = $repository->find($id);
        $movies = $repository->findAll();

        $form = $this->createForm(MoviesType::class, $movie);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($movie);
            $entityManager->flush();
            return $this->redirectToRoute('movies.list');
        }elseif($form->isSubmitted() && !$form->isValid()){
            $add = 2;
            return $this->render('movies/index.html.twig', [
                'add' => $add,
                'movies' => $movies,
                'formmovie' => $form->createView(),
            ]);
        }else{
            return $this->render('movies/index.html.twig', [
                'formmovie' => $form->createView(),
                'movies' => $movies,
                'add' => $add,
            ]);
        }
        
        return $this->redirectToRoute('movies.list');
    }
}