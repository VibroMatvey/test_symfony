<?php

namespace App\Controller\Admin;

use App\Controller\Admin\Tables\TablesCrudController;
use App\Entity\GuestList;
use App\Entity\Tables;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Locale;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $routeBuilder = $this->container->get(AdminUrlGenerator::class);
        $url = $routeBuilder->setController(TablesCrudController::class)->generateUrl();

        return $this->redirect($url);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Административная панель');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToCrud('Столы', 'fas fa-comments', Tables::class);
        yield MenuItem::linkToCrud('Гости', 'fas fa-map-marker-alt', GuestList::class);
    }
}
