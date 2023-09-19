<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/back/category")
 */
class CategoryController extends AbstractController
{
    /**
     * @Route("/", name="app_category_index", methods={"GET"})
     */
    public function index(CategoryRepository $categoryRepository): Response
    {

        // visual of the page in the back for the categories
        return $this->render('category/index.html.twig', [
            'categories' => $categoryRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_category_new", methods={"GET", "POST"})
     */
    public function new(Request $request, CategoryRepository $categoryRepository): Response
    {
        // creation of an instance of category
        $category = new Category();
        // creation of the form
        $form = $this->createForm(CategoryType::class, $category);
        // store answers in the form
        $form->handleRequest($request);
        // if the form is sent and complete then we save
        if ($form->isSubmitted() && $form->isValid()) {
            $categoryRepository->add($category, true);
            // returns to the path after validation
            return $this->redirectToRoute('app_category_index', [], Response::HTTP_SEE_OTHER);
        }
        // validation of the new category
        return $this->renderForm('category/new.html.twig', [
            'category' => $category,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_category_show", methods={"GET"})
     */
    public function show(Category $category): Response
    {
        // visual to see one category
        return $this->render('category/show.html.twig', [
            'category' => $category,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_category_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Category $category, CategoryRepository $categoryRepository): Response
    {
        // creation of the form
        $form = $this->createForm(CategoryType::class, $category);
        // store answers in the form
        $form->handleRequest($request);
        // if the form is sent and complete then we save
        if ($form->isSubmitted() && $form->isValid()) {
            $categoryRepository->add($category, true);
            // returns to the path after validation
            return $this->redirectToRoute('app_category_index', [], Response::HTTP_SEE_OTHER);
        }
        // validation of the edition of the category
        return $this->renderForm('category/edit.html.twig', [
            'category' => $category,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_category_delete", methods={"POST"})
     */
    public function delete(Request $request, Category $category, CategoryRepository $categoryRepository): Response
    {
        // recovery of the id and the token to delete the category
        if ($this->isCsrfTokenValid('delete'.$category->getId(), $request->request->get('_token'))) {
            $categoryRepository->remove($category, true);
        }
        // returns to the path after delete
        return $this->redirectToRoute('app_category_index', [], Response::HTTP_SEE_OTHER);
    }
}
