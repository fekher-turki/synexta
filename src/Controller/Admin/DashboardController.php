<?php

namespace App\Controller\Admin;

use App\Entity\Contact;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    private $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }
    
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $users = $this->manager->getRepository(User::class)->count([]);
        $applications = $this->manager->getRepository(Contact::class)->count([]);
        $applications_logs = $this->manager->getRepository(Contact::class)->findBy([], ['id' => 'DESC'], 10);
        return $this->render('admin/dashboard.html.twig', [
            'users' => $users,
            'applications' => $applications,
            'applications_logs' => $applications_logs]);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Synexta - Admin');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Tableau de bord', 'fa fa-gauge');
        yield MenuItem::linkToCrud('Applications', 'fas fa-file', Contact::class);
        yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-user', User::class);
        yield MenuItem::linkToRoute('Retour à l\'accueil', 'fas fa-rotate-right', 'home.index');
    }
}
