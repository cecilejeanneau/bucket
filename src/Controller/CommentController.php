<?php

namespace App\Controller;

use App\Entity\Wish;
use App\Repository\CommentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/comment', name: 'comment_')]
class CommentController extends AbstractController
{
    #[Route('/wishes/details/{id}/comment', name: 'wish_add')]
    public function wishComments(int $id, Request $request, CommentRepository $commentRepository): Response {
        $wish = $this->getDoctrine()->getRepository(Wish::class)->find($id);
    }

    #[Route('/comment', name: 'app_comment')]
    public function index(): Response
    {
        return $this->render('comment/index.html.twig', [
            'controller_name' => 'CommentController',
        ]);
    }
}
