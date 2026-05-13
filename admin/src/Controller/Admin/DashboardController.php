<?php

namespace App\Controller\Admin;

use App\Repository\ContactInfoRepository;
use App\Repository\ExperienceRepository;
use App\Repository\ExpertiseRepository;
use App\Repository\MethodeStepRepository;
use App\Repository\PitchDomainRepository;
use App\Repository\RealisationRepository;
use App\Repository\SourceRepository;
use App\Repository\StatRepository;
use App\Repository\TemoignageRepository;
use App\Repository\UserRepository;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;

#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
class DashboardController extends AbstractDashboardController
{
    public function __construct(
        private UserRepository $users,
        private TemoignageRepository $temoignages,
        private ExperienceRepository $experiences,
        private ExpertiseRepository $expertises,
        private StatRepository $stats,
        private ContactInfoRepository $contactInfos,
        private PitchDomainRepository $pitchDomains,
        private RealisationRepository $realisations,
        private MethodeStepRepository $methodeSteps,
        private SourceRepository $sources,
    ) {}

    public function index(): Response
    {
        return $this->render('admin/dashboard.html.twig', [
            'nbUsers'        => $this->users->count([]),
            'nbTemoignages'  => $this->temoignages->count([]),
            'nbExperiences'  => $this->experiences->count([]),
            'nbExpertises'   => $this->expertises->count([]),
            'nbStats'        => $this->stats->count([]),
            'nbPitchDomains' => $this->pitchDomains->count([]),
            'nbRealisations' => $this->realisations->count([]),
            'nbSources'      => $this->sources->count([]),
        ]);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Gilles Dimbert — Admin')
            ->setFaviconPath('favicon.ico')
            ->renderContentMaximized();
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Tableau de bord', 'fa fa-home');

        yield MenuItem::section('Contenu du site');
        yield MenuItem::linkTo(TemoignageCrudController::class, 'Témoignages', 'fa fa-quote-left');
        yield MenuItem::linkTo(ExperienceCrudController::class, 'Parcours', 'fa fa-briefcase');
        yield MenuItem::linkTo(ExpertiseCrudController::class, 'Expertises', 'fa fa-star');
        yield MenuItem::linkTo(RealisationCrudController::class, 'Réalisations', 'fa fa-trophy');
        yield MenuItem::linkTo(PitchDomainCrudController::class, "Domaines d'intervention", 'fa fa-bullseye');
        yield MenuItem::linkTo(MethodeStepCrudController::class, 'Méthode', 'fa fa-list-ol');
        yield MenuItem::linkTo(StatCrudController::class, 'Statistiques', 'fa fa-chart-bar');
        yield MenuItem::linkTo(SourceCrudController::class, 'Sources publiques', 'fa fa-link');

        yield MenuItem::section('Paramètres');
        yield MenuItem::linkTo(ContactInfoCrudController::class, 'Contact & Disponibilité', 'fa fa-address-card');
        yield MenuItem::linkTo(UserCrudController::class, 'Comptes admin', 'fa fa-user');

        yield MenuItem::section('');
        yield MenuItem::linkToUrl('Voir le site', 'fa fa-eye', '/');
    }
}
