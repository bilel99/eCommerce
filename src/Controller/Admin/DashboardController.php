<?php
namespace App\Controller\Admin;

use http\Env\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{

    /**
     * @IsGranted("ROLE_ADMIN", message="Access denied 302")
     * @Route("/admin/dashboard", name="admin.dashboard")
     */
    public function index()
    {
        return $this->render('admin/dashboad/dashboard.html.twig', [
            'page_controller' => 'dashboard'
        ]);
    }

}
