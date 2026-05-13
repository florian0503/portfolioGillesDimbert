<?php

namespace App\Controller;

use App\Repository\ContactInfoRepository;
use App\Repository\ExperienceRepository;
use App\Repository\ExpertiseRepository;
use App\Repository\MethodeStepRepository;
use App\Repository\PitchDomainRepository;
use App\Repository\RealisationRepository;
use App\Repository\SourceRepository;
use App\Repository\StatRepository;
use App\Repository\TemoignageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PortfolioController extends AbstractController
{
    #[Route('/', name: 'portfolio')]
    public function index(
        ContactInfoRepository  $contactInfos,
        StatRepository         $stats,
        ExpertiseRepository    $expertises,
        PitchDomainRepository  $pitchDomains,
        RealisationRepository  $realisations,
        ExperienceRepository   $experiences,
        TemoignageRepository   $temoignages,
        MethodeStepRepository  $methodeSteps,
        SourceRepository       $sources,
    ): Response {
        $contact = $contactInfos->findOneBy([]);

        $temoignagesGrouped = [
            'directions'    => $temoignages->findBy(['category' => 'directions',    'visible' => true], ['sortOrder' => 'ASC']),
            'dialogue_social' => $temoignages->findBy(['category' => 'dialogue_social', 'visible' => true], ['sortOrder' => 'ASC']),
            'experts'       => $temoignages->findBy(['category' => 'experts',       'visible' => true], ['sortOrder' => 'ASC']),
        ];

        return $this->render('portfolio/index.html.twig', [
            'contact'      => $contact,
            'stats'        => $stats->findBy([], ['sortOrder' => 'ASC']),
            'expertises'   => $expertises->findBy(['visible' => true], ['sortOrder' => 'ASC']),
            'pitchDomains' => $pitchDomains->findBy([], ['sortOrder' => 'ASC']),
            'realisations' => $realisations->findBy([], ['sortOrder' => 'ASC']),
            'experiences'  => $experiences->findBy([], ['sortOrder' => 'ASC']),
            'temoignages'  => $temoignagesGrouped,
            'methodeSteps' => $methodeSteps->findBy([], ['sortOrder' => 'ASC']),
            'sources'      => $sources->findBy(['visible' => true], ['sortOrder' => 'ASC']),
        ]);
    }
}
