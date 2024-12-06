<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Wish;
use App\Form\WishType;
use App\Repository\CategoryRepository;
use App\Repository\WishRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/wishes', name: 'wishes_')]
class WishController extends AbstractController
{
    #[Route('', name: 'list', methods: ['GET'])]
    public function list(WishRepository $wishRepository): Response
    {
        $wishes = $wishRepository->findBy(['isPublished' => true], ['dateCreated' => 'DESC']);

        return $this->render('wish/list.html.twig', [
            'wishes' => $wishes
        ]);
    }

    #[Route('/details/{id}', name: 'details', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function details(#[MapEntity] Wish $wish): Response
    {
//        $wishName = "Whales swimming";
        return $this->render('wish/details.html.twig', [
            'wish' => $wish,
        ]);
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/create', name: 'create', methods: ['GET', 'POST'])]
    public function create(
        Request $request,
        EntityManagerInterface $manager,
        CategoryRepository $categoryRepository,
        Security $security,
    ): Response
    {
        $wish = new Wish();

//        $categories = $categoryRepository->findAll();
////        if($category) {
//            $category = $categoryRepository->find($category);
//            $wish->setCategory($category);
////        }

        $wishForm = $this->createForm(WishType::class, $wish);
        $wishForm->handleRequest($request);

        if($wishForm->isSubmitted() && $wishForm->isValid()){
            $wish->setUser($security->getUser());

            $manager->persist($wish);
            $manager->flush();

            $this->addFlash('success', 'Wish added successfully!');
            return $this->redirectToRoute('wishes_details', ['id' => $wish->getId()]);
        }

        return $this->render('wish/add.html.twig', [
            'wishForm' => $wishForm,
        ]);
    }

    #[Route('/update/{id}', name: 'update', requirements: ['id' => '[0-9]+'], methods: ['GET', 'POST'])]
    public function update(Request $request, EntityManagerInterface $manager, #[MapEntity] Wish $wish, Security $security): Response
    {
        $wishUser = $wish->getUser();
        if($this->getUser() !== $wishUser) {
//            return throw $this->createAccessDeniedException();
            $this->addFlash('error', 'You are not allowed to delete this wish!');
            return $this->redirectToRoute('wishes_details', ['id' => $wish->getId()]);
        }

        $wishForm = $this->createForm(WishType::class, $wish);
        $wishForm->handleRequest($request);

        if($wishForm->isSubmitted() && $wishForm->isValid()){

            $manager->persist($wish);
            $manager->flush();

            $this->addFlash('success', 'Wish updated successfully!');
            return $this->redirectToRoute('wishes_details', ['id' => $wish->getId()]);
        }

        return $this->render('wish/update.html.twig', [
            'wishForm' => $wishForm,
        ]);


    }


    #[Route('/delete/{id}', name: 'delete', requirements: ['id' => '[0-9]+'], methods: ['GET'])]
    public function delete(Request $request, EntityManagerInterface $manager, #[MapEntity] Wish $wish): Response
    {
        $wishUser = $wish->getUser();
        if($this->getUser() !== $wishUser) {
//            return throw $this->createAccessDeniedException();
            $this->addFlash('error', 'You are not allowed to delete this wish!');
            return $this->redirectToRoute('wishes_details', ['id' => $wish->getId()]);
        }

        $manager->remove($wish);
        $manager->flush();

        $this->addFlash('success', 'Wish deleted successfully!');

        return $this->redirectToRoute('wishes_list');
    }
}
