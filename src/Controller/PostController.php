<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use function Symfony\Component\DependencyInjection\Loader\Configurator\param;

#[Route('/posts', name: 'post.')]
class PostController extends AbstractController
{
    #[Route('', name: 'index')]
    public function index(PostRepository $postRepository): Response
    {

        $posts = $postRepository->findAll();

        return $this->render('post/index.html.twig', [
            'posts' => $posts,
            'controller_name' => 'PostController',
        ]);
    }

    #[Route('/create', name: 'create')]
    public function create(Request $request, EntityManagerInterface $em)
    {
        //create a new post with title
        $post = new Post();

        $form = $this->createForm(type: PostType::class, data: $post);

        $form->handleRequest($request);
        $form->getErrors();
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($post);
            $em->flush();
        }
        return $this->render(view: 'post/create.html.twig', parameters: [
            'form' => $form
        ]);
    }

    #[Route('/show/{id}', name: 'show')]
    public function show(Post $post)
    {
        return $this->render(view: 'post/show.html.twig', parameters: [
            'post' => $post
        ]);
    }

    #[Route('/delete/{id}', name: 'delete')]
    public function delete(Post $post, EntityManagerInterface $em)
    {
        $em->remove($post);
        $em->flush();
        $this->addFlash(type: 'success', message: 'Post successfully deleted');
        return $this->redirect($this->generateUrl(route: 'post.index'));
    }
}
