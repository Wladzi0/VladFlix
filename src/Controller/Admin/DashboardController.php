<?php

namespace App\Controller\Admin;

use App\Entity\Film;
use App\Entity\Serial;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\CrudUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        $routeBuilder = $this->get(CrudUrlGenerator::class)->build();
        return $this->redirect($routeBuilder->setController(FilmCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Netflix');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::section('Control of entities');
        yield MenuItem::linkToCrud('Films', null, Film::class);
        yield MenuItem::linkToCrud('Serials',null,Serial::class);
        yield MenuItem::linkToCrud('Users', null, User::class);

    }
}
