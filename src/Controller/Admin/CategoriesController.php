<?php

namespace App\Controller\Admin;

use App\Entity\Category;

use App\Form\CategoryType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoriesController extends AbstractController
{
    /**
     * @IsGranted("ROLE_ADMIN", message="Access denied 302")
     * Class CategoriesController
     * @Route("/admin/categories", name="admin.categories")
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $categories = $this->getDoctrine()->getRepository(Category::class)
            ->findAll();

        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();
            $this->addFlash('success', 'Created successfully!');
            return $this->redirectToRoute('admin.categories');
        }

        return $this->render('admin/categories/index.html.twig', [
            'page_controller' => 'categories',
            'categories' => $categories,
            'form' => $form->createView()
        ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN", message="Access denied 302")
     * @Route("/admin/category/edit/{id}", name="admin.category.edit")
     * @param Request $request
     * @param Category $category
     * @return RedirectResponse
     */
    public function editCategory(Request $request, Category $category): Response
    {
        $em = $this->getDoctrine()->getManager();
        $category->setName($request->request->get('name'));
        $em->persist($category);
        $em->flush();
        $this->addFlash('success', 'the category is updated!');
        return $this->redirectToRoute('admin.categories');
    }

    /**
     * @IsGranted("ROLE_ADMIN", message="Access denied 302")
     * @Route("/admin/category/delete/{id}", name="admin.category.delete")
     * @param Category $category
     * @return RedirectResponse
     */
    public function deleteCategory(Category $category)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($category);
        $em->flush();
        $this->addFlash('success', 'The category is deleted!');
        return $this->redirectToRoute('admin.categories');
    }
}
