<?php

namespace Admin\DashboardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DashboardController extends Controller
{
    public function indexAction()
    {
        return $this->render('AdminDashboardBundle:Dashboard:index.html.twig');
    }
}
