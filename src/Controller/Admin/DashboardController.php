<?php
namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DashboardController extends AbstractController
{


    public function index()
    {
        return $this->render('admin/dashboad/dashboard.html.twig');
    }

}