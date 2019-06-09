<?php

namespace App\Controller\Admin;

use App\Entity\Media;
use App\Entity\User;
use App\Form\ProfilUserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @IsGranted("ROLE_ADMIN", message="Access denied 302")
 * Class UserAdminController
 * @package App\Controller\Admin
 */
class UserAdminController extends AbstractController
{
    /**
     * @IsGranted("ROLE_ADMIN", message="Access denied 302")
     * @Route("/admin/user", name="admin.user")
     */
    public function index(): Response
    {
        $users = $this->getDoctrine()->getRepository(User::class)
            ->findAll();
        return $this->render('admin/user/index.html.twig', [
            'page_controller' => 'user',
            'users' => $users
        ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN", message="Access denied 302")
     * @Route("/admin/user/show/{id}", name="admin.user.show")
     * @param User $user
     * @return Response
     */
    public function show(User $user)
    {
        $user = $this->getDoctrine()->getRepository(User::class)
            ->getUser($user->getId());
        return $this->render('admin/user/show.html.twig', [
            'page_controller' => 'user',
            'user' => $user[0]
        ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN", message="Access denied 302")
     * @Route("/admin/user/edit/{id}", name="admin.user.edit")
     * @param Request $request
     * @param User $user
     * @return RedirectResponse|Response
     */
    public function edit(Request $request, User $user): Response
    {
        $form = $this->createForm(ProfilUserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            if ($form['media']->getData()->getFile() !== null){
                $media = new Media();
                $media->setName('Avatar');
                $media->setFile($form['media']->getData()->getFile());
                $user->setMedia($media);
                $em->persist($media);
            }
            $em->persist($user);
            $em->flush();
            $this->addFlash('success', 'The user is updated successfully!');
            return $this->redirectToRoute('admin.user');
        }

        return $this->render('admin/user/edit.html.twig', [
            'page_controller' => 'user',
            'user' => $user,
            'form' => $form->createView()
        ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN", message="Access denied 302")
     * @Route("/admin/user/delete/{id}", name="admin.user.delete")
     * @param User $user
     * @return RedirectResponse
     */
    public function deleteUser(User $user)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();
        $this->addFlash('success', 'User is deleted!');
        return $this->redirectToRoute('admin.user');
    }

    /**
     * @IsGranted("ROLE_ADMIN", message="Access denied 302")
     * @Route("/admin/user/add/admin", name="admin.add.admin.user")
     * @param Request $request
     * @return Response
     */
    public function addAdminUser(Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        $user = $this->getDoctrine()->getRepository(User::class)
            ->findOneBy(['email' => 'admin@gmail.com']);

        if (empty($user) && $user === null) {
            $user = new User();
            $em = $this->getDoctrine()->getManager();
            $user->setEmail('admin@gmail.com');
            $user->setName('Admin');
            $user->setFirstname('Admin');
            $user->setRoles(User::ROLE_ADMIN);
            $hash = $encoder->encodePassword($user, 'admin');
            $user->setPassword($hash);
            $em->persist($user);
            $em->flush();
            $this->addFlash('success', 'Your created Admin account is successfully!');
            return $this->redirectToRoute('admin.user');
        } else {
            $this->addFlash('warning', 'Your Admin account exist!');
            return $this->redirectToRoute('admin.user');
        }
    }

}
