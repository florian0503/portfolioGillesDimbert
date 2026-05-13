<?php

namespace App\DataFixtures;

use App\Entity\ContactInfo;
use App\Entity\Expertise;
use App\Entity\Experience;
use App\Entity\MethodeStep;
use App\Entity\PitchDomain;
use App\Entity\Realisation;
use App\Entity\Source;
use App\Entity\Stat;
use App\Entity\Temoignage;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $hasher) {}

    public function load(ObjectManager $em): void
    {
        $this->loadUser($em);
        $this->loadContactInfo($em);
        $this->loadStats($em);
        $this->loadExpertises($em);
        $this->loadExperiences($em);
        $this->loadTemoignages($em);
        $this->loadPitchDomains($em);
        $this->loadRealisations($em);
        $this->loadMethodeSteps($em);
        $this->loadSources($em);
        $em->flush();
    }

    // ─── User admin ────────────────────────────────────────────────────────────

    private function loadUser(ObjectManager $em): void
    {
        $user = new User();
        $user->setEmail('admin@gilles-dimbert.fr');
        $user->setRoles(['ROLE_ADMIN']);
        $user->setPassword($this->hasher->hashPassword($user, 'admin1234'));
        $em->persist($user);
    }

    // ─── Contact info ──────────────────────────────────────────────────────────

    private function loadContactInfo(ObjectManager $em): void
    {
        $c = (new ContactInfo())
            ->setPhone('06 08 46 85 63')
            ->setEmail('gilles.dimbert@gmail.com')
            ->setLinkedin('https://www.linkedin.com/in/gilles-dimbert')
            ->setLocation('Lyon · Mobilité nationale')
            ->setAvailability('juin 2026')
            ->setExtraInfo("Juge prud'homal depuis 2002");
        $em->persist($c);
    }

    // ─── Stats ─────────────────────────────────────────────────────────────────

    private function loadStats(ObjectManager $em): void
    {
        $data = [
            [1, 30,   '+', "ans d'expérience\nen groupes & ETI"],
            [2, 2800, '+', "départs pilotés\navec & sans PSE"],
            [3, 3000, '+', "collaborateurs\nsous responsabilité"],
            [4, 0,    '',  "jour de grève\nWincanton · Bernard"],
        ];
        foreach ($data as [$order, $target, $suffix, $label]) {
            $s = (new Stat())->setSortOrder($order)->setTarget($target)->setSuffix($suffix)->setLabel($label);
            $em->persist($s);
        }
    }

    // ─── Expertises ────────────────────────────────────────────────────────────

    private function loadExpertises(ObjectManager $em): void
    {
        $data = [
            [1, 'Négociation',   "Gestion autonome de négociations syndicales dans des contextes parfois hostiles. Présidence de CSE (40 élus). Accords majoritaires en délais contraints."],
            [2, 'Transformation',"Restructurations majeures, PSE, risques psychosociaux, droits d'alerte, autorités de tutelle. Croissance organique, carve-out, intégrations complexes."],
            [3, 'Pilotage RH',   "Management d'équipes RH de 2 à 30 personnes. Mise en place de politiques RH complètes. Relations sociales et protection collective."],
            [4, 'Modernisation', "Implémentation SIRH, logiciels de paie, data RH, digitalisation des processus, marque employeur et transformation culturelle."],
        ];
        foreach ($data as [$order, $title, $desc]) {
            $e = (new Expertise())->setSortOrder($order)->setTitle($title)->setDescription($desc)->setVisible(true);
            $em->persist($e);
        }
    }

    // ─── Expériences (parcours) ────────────────────────────────────────────────

    private function loadExperiences(ObjectManager $em): void
    {
        $items = [
            [
                'sortOrder'       => 1,
                'period'          => '2025–2026',
                'type'            => 'transition',
                'company'         => 'Groupe confidentiel',
                'companySubtitle' => null,
                'role'            => 'DRH · Management de transition',
                'context'         => 'Enseignement privé + immobilier + hôtellerie + résidences étudiantes · 7 campus · 700 salariés · Actionnariat familial',
                'logo'            => null,
                'tags'            => ['Transition', '700 sal.', 'Multi-activités'],
                'externalLinks'   => [],
                'detailGroups'    => [
                    ['label' => 'Réorganisation & social — pôle enseignement', 'items' => [
                        "Structuration équipe RH ; mise en place de process internes",
                        "Contexte syndical conflictuel ; droits d'alerte locaux",
                        "Contentieux judiciaires à forts enjeux",
                        "Restructuration interne (−15 % des effectifs)",
                        "Mise en place politique GPEC globale",
                    ]],
                    ['label' => 'Croissance — pôle immobilier / promotion', 'items' => [
                        "+66 % d'activité anticipé (3 000 → 5 000 logements en 36 mois)",
                        "Organisation managériale, nouveaux process, plan de formation",
                        "Identification des compétences nécessaires et recrutements ciblés",
                    ]],
                ],
            ],
            [
                'sortOrder'       => 2,
                'period'          => '2025',
                'type'            => 'transition',
                'company'         => 'Intermarché Pennes Mirabeau',
                'companySubtitle' => null,
                'role'            => 'DRH · Management de transition',
                'context'         => '130 salariés · Distribution alimentaire BtoC · Contexte syndical Marseille Nord',
                'logo'            => 'intermarche.png',
                'tags'            => ['Transition', '130 lic. éco.', 'PSE'],
                'externalLinks'   => [],
                'detailGroups'    => [
                    ['label' => 'PSE & fermeture totale', 'items' => [
                        "Pilotage et mise en œuvre PSE ; 130 licenciements économiques",
                        "Signature accord majoritaire Livre 1 en délais records",
                        "Négociation DDETS, Médecine du Travail",
                        "Cabinet outplacement Alixio Mobilité ; expertise SECAFI",
                        "Procédure Florange ; RPS Livre 4",
                        "Participation cellule de pilotage — fermeture de 29 supermarchés et hypermarchés",
                    ]],
                ],
            ],
            [
                'sortOrder'       => 3,
                'period'          => '2020–2025',
                'type'            => 'cdi',
                'company'         => 'Place du Marché',
                'companySubtitle' => 'Toupargel',
                'role'            => 'DRH puis Mandataire social · CDI',
                'context'         => '2 200 collab. · 150 sites · 190 M€ CA · Distribution alimentaire BtoC · Management équipe RH 25 pers.',
                'logo'            => 'place-du-marche.png',
                'tags'            => ['CDI', '2 200 sal.', 'Mandataire social'],
                'externalLinks'   => [],
                'detailGroups'    => [
                    ['label' => 'Build & culture', 'items' => [
                        "Refonte statut collectif : organisation du travail, rémunérations, protection collective — 100 % des accords signés",
                        "People review, plan de formation, création SST",
                        "Changement logiciel de paie (ADP) ; digitalisation (AMOA avec IMPLID)",
                    ]],
                    ['label' => 'Restructuration & liquidation', 'items' => [
                        "Réduction significative des effectifs (plusieurs centaines de départs en 36 mois)",
                        "Mandataire social : liquidation judiciaire — 2 200 licenciements économiques",
                        "Gestion de grèves sur les plateformes logistiques ; organes de procédure",
                        "Cabinet outplacement LHH",
                        "Depuis 04.2023 : Président du Family Office français des cofondateurs de Grand Frais",
                    ]],
                ],
            ],
            [
                'sortOrder'       => 4,
                'period'          => '2012–2020',
                'type'            => 'cdi',
                'company'         => 'Groupe Bernard',
                'companySubtitle' => null,
                'role'            => 'DRH · CDI',
                'context'         => '3 000 collab. · 100 sites · 1,2 Md€ CA · Distribution automobile · Management équipe RH 30 pers. + opé. 150 pers.',
                'logo'            => null,
                'tags'            => ['CDI', '3 000 sal.', 'DGO'],
                'externalLinks'   => [
                    ['label' => "L'Argus", 'url' => 'https://www.largus.fr/pros/actualite-automobile/gilles-messier-prend-la-direction-generale-du-groupe-bernard-5763384.html'],
                ],
                'detailGroups'    => [
                    ['label' => 'Réorganisation & social', 'items' => [
                        "Restructuration ; −190 postes en 6 mois — zéro jour de grève",
                    ]],
                    ['label' => 'Croissance & structuration', 'items' => [
                        "Hyper croissance externe ; +750 collaborateurs en 18 mois",
                        "Création SIRH global (onboarding, GPEC, masse salariale, dashboard, EVP) — commercialisé au groupe Emil Frey",
                        "Marque employeur ; label Happy at Work ; digitalisation RH (DECIDIUM)",
                        "Audit et appel d'offre protection collective",
                        "Coaching nouveaux membres Comité de Direction",
                    ]],
                    ['label' => 'Direction générale opérationnelle (2016–2020)', 'items' => [
                        "Création d'une nouvelle branche : call center interne, 1er franchisé Hertz France (15 agences), vente aux enchères, location engins de manutention, réseau 20 pts de vente VO",
                        "Redressement : CA +20 %, RN +30 %",
                    ]],
                ],
            ],
            [
                'sortOrder'       => 5,
                'period'          => '2000–2011',
                'type'            => 'cdi',
                'company'         => 'Wincanton',
                'companySubtitle' => null,
                'role'            => 'DRH · CDI',
                'context'         => '2 500 collab. · 30 sites · 200 M€ CA · Logistique & Transport BtoB · Groupe anglais 32 000 sal.',
                'logo'            => 'wincanton.png',
                'tags'            => ['CDI', '2 500 sal.', 'Groupe anglais'],
                'externalLinks'   => [
                    ['label' => 'Supply Chain Mag', 'url' => 'https://supplychainmagazine.fr/nl/2012/trois-nouvelles-tetes-chez-tlf/'],
                    ['label' => "JO — Prud'hommes", 'url' => 'https://www.unsa.org/IMG/pdf/jo9122022nominations_conseillers_prud_hommes.pdf'],
                ],
                'detailGroups'    => [
                    ['label' => 'Restructurations & social', 'items' => [
                        "20 PSE en 11 ans ; +1 500 licenciements — zéro jour de grève",
                        "Carve-out ; intégration +700 collaborateurs ; convergence des statuts collectifs",
                        "10+ conventions collectives harmonisées ; recrutements en contexte de pénurie",
                        "Négociation accords de méthode",
                    ]],
                    ['label' => 'Build & culture', 'items' => [
                        "Négociation du statut collectif ayant servi de référence à la CCN",
                        "Directeur de la communication interne",
                        "Évènements pour favoriser la transversalité (concours meilleurs cariste, innovation SSCT...)",
                        "Mise en place d'ambassadeurs",
                    ]],
                    ['label' => 'Rôles complémentaires', 'items' => [
                        "Administrateur TLF — syndicat patronal national Transport & Logistique",
                        "Co-Président commission sociale nationale TLF",
                        "Administrateur OCPO transport (financement de la formation)",
                        "Administrateur Klesia (mutuelle & prévoyance de branche)",
                        "Administrateur GNFA (organisme de formation de branche)",
                        "Négociateur États Généraux du Transport — patronage Ministère",
                    ]],
                ],
            ],
            [
                'sortOrder'       => 6,
                'period'          => '1995–2000',
                'type'            => 'cdi',
                'company'         => 'Alstom Power',
                'companySubtitle' => null,
                'role'            => 'DRH · Responsable formation · CDI',
                'context'         => '1 200 collab. · Fabrication de turbines · Industrie lourde · Management équipe RH 15 pers.',
                'logo'            => 'alstom.png',
                'tags'            => ['CDI', '1 200 sal.', 'Industrie'],
                'externalLinks'   => [],
                'detailGroups'    => [
                    ['label' => "Restructuration & fermeture d'usine", 'items' => [
                        "PSE et fermeture d'usine ; crise amiante",
                        "Expérience de séquestration",
                        "Groupe à organisation matricielle internationale — approche politique nécessaire",
                    ]],
                    ['label' => 'Build & culture', 'items' => [
                        "Pyramide des âges très défavorable — vaste plan de gestion des emplois et des carrières",
                        "Transformation en profondeur de plusieurs emplois et filières",
                        "GPEC ; transformation profonde des métiers et des compétences",
                    ]],
                ],
            ],
            [
                'sortOrder'       => 7,
                'period'          => '1993–1995',
                'type'            => 'cdd',
                'company'         => 'Thomson · Thalès',
                'companySubtitle' => null,
                'role'            => 'Contrôleur financier · CDD',
                'context'         => '1 000 collab. · Industrie défense · Groupe matriciel international',
                'logo'            => 'thales.png',
                'tags'            => ['CDD', 'Défense'],
                'externalLinks'   => [],
                'detailGroups'    => [
                    ['label' => 'Finance & contrôle', 'items' => [
                        "Contrôle financier d'usines dans un groupe matriciel international",
                    ]],
                ],
            ],
        ];

        foreach ($items as $data) {
            $e = new Experience();
            $e->setSortOrder($data['sortOrder'])
              ->setPeriod($data['period'])
              ->setType($data['type'])
              ->setCompany($data['company'])
              ->setCompanySubtitle($data['companySubtitle'])
              ->setRole($data['role'])
              ->setContext($data['context'])
              ->setLogo($data['logo'])
              ->setTags($data['tags'])
              ->setExternalLinks($data['externalLinks'])
              ->setDetailGroups($data['detailGroups']);
            $em->persist($e);
        }
    }

    // ─── Témoignages ───────────────────────────────────────────────────────────

    private function loadTemoignages(ObjectManager $em): void
    {
        $data = [
            // directions
            ['directions', 1, "Gilles a été un collaborateur précieux lors de la restructuration du groupe Bernard.", 'Jean-Pierre Laurent', 'Directeur Général — Groupe Bernard'],
            ['directions', 2, "Leader engagé, Gilles sait gérer des situations complexes et proposer des transformations pertinentes, avec une vision transverse du business.", 'Gilles Messier', 'Directeur Général — Groupe Bernard'],
            ['directions', 3, "Gilles sait trouver des solutions pragmatiques et adaptées à chaque activité. Il travaille vite et bien.", 'Laurent Farman', 'Directeur Général Trucks — Groupe Bernard'],
            ['directions', 4, "Gilles allie une grande capacité d'analyse à une remise en question permanente, faisant de lui un partenaire efficace.", 'Philippe Gagnepain', 'DG Mercedes-Benz Trucks — Groupe Bernard'],
            ['directions', 5, "Gilles a su restaurer la confiance des salariés et des IRP, tout en menant des transformations profondes avec humanité et efficacité. Homme d'engagement, il a accompagné les équipes jusqu'au dernier jour dans un contexte de grande difficulté.", 'Brieuc Fruchon', 'Président — Place du Marché'],
            ['directions', 6, "Avec sa solidité professionnelle, Gilles a toujours été respecté par l'ensemble des syndicats et partenaires sociaux.", 'Egbert Maagd', "DG Europe de l'Ouest — Wincanton"],
            ['directions', 7, "Gilles is a highly experienced international HR Director and a key contributor to European management teams.", 'Nigel Sullivan', 'Group HR Director — Wincanton'],
            ['directions', 8, "Dans un contexte particulièrement sensible, les objectifs fixés par la Direction Générale ont été atteints grâce à son sens de l'écoute et sa capacité à instaurer un climat de confiance.", 'Gérard Lejay', 'DG Associé — Intermarché ITMAI'],
            ['directions', 9, "Gilles possède une vision globale de l'entreprise et une capacité rare à résoudre rapidement les problématiques les plus complexes.", 'Jean-Michel Galand', 'Responsable Régional Logistique — Wincanton'],
            ['directions', 10, "Intervenant dès la phase commerciale puis de due diligence sociale, Gilles a fait de la reprise de personnel un facteur différenciant dans la stratégie de développement du groupe.", 'Thierry Lambert', "Directeur Bureau d'études — Wincanton"],
            ['directions', 11, "Sa vision à 360° nous a permis de mener des transformations profondes en tenant compte de l'accompagnement humain.", 'Pierre-Yves Cherblanc', 'Directeur Commercial — Place du Marché'],
            ['directions', 12, "Gilles combine vision stratégique, leadership managérial et expertise RH pour fédérer les équipes autour des enjeux les plus exigeants.", 'Eric Sarrazin', 'Directeur Régional — Place du Marché'],
            // dialogue_social
            ['dialogue_social', 1, "Gilles est un professionnel respecté, y compris par les partenaires sociaux, pour sa loyauté et son sens du dialogue.", 'Patrick Van Craeyenest', 'Bureau fédéral CGT Transport'],
            ['dialogue_social', 2, "Sur un site particulièrement complexe, Gilles a su s'adapter très rapidement et contribuer à un résultat collectif inespéré.", 'Eric Maury', 'Directeur Affaires Sociales Groupe — Intermarché'],
            ['dialogue_social', 3, "Gilles a su s'intégrer immédiatement dans un contexte délicat et faire équipe avec efficacité et engagement.", 'Patricia Cadoux', 'DRH Groupe — Intermarché'],
            ['dialogue_social', 4, "Les délais ont été respectés et les objectifs atteints, avec l'obtention d'un accord majoritaire auprès des organisations syndicales.", 'Maxime Poznanski', 'Responsable Pôle RH — Intermarché'],
            ['dialogue_social', 5, "Esprit de décision, facilitateur et grand manager, il a su embarquer les équipes dans des projets structurants.", 'Manuel Martin', 'Délégué Syndical Central CFDT — Wincanton'],
            ['dialogue_social', 6, "Grâce à son écoute et une préparation sans faille, Gilles a instauré un dialogue social apaisé et constructif, y compris en période de crise comme la pandémie de Covid.", 'Chadia Breavoine', 'Élue CSE — Place du Marché'],
            ['dialogue_social', 7, "DRH loyal et respectueux de la parole donnée, Gilles sait construire des compromis durables même en situation de conflit.", 'Jean-Marc Folens', 'Délégué Syndical Central FO — Wincanton'],
            ['dialogue_social', 8, "Professionnel de la négociation, respect de la parole donnée et recherche constante du compromis gagnant-gagnant.", 'Philippe Choutet', 'Directeur Juridique & Négociateur de Branche — TLF'],
            ['dialogue_social', 9, "Organisation rigoureuse, délais tenus et transmission exemplaire des dossiers, au bénéfice direct des salariés.", 'Direction Générale France Travail', 'Dossier Place du Marché'],
            ['dialogue_social', 10, "Organisation remarquable, communication fluide et délais tenus : la cellule liquidative pilotée par Gilles Dimbert a permis une prise en charge rapide et efficace des salariés, dans un contexte pourtant très contraint.", 'Direction de Projet — LHH', 'Dossier Place du Marché'],
            // experts
            ['experts', 1, "Gilles a démontré une capacité exceptionnelle à gérer des contextes sociaux à très forts enjeux et à gagner le respect des partenaires sociaux.", 'Gérard Cambrune', 'DRH — Alstom Power'],
            ['experts', 2, "Les modules SIRH développés couvrent l'ensemble du spectre RH sur un périmètre de plus de 10 000 collaborateurs.", 'Emmanuel Lemoine', 'DRH — Emil Frey France'],
            ['experts', 3, "Grâce à son approche pragmatique et sa compréhension des nouvelles technologies, Gilles met en place des solutions concrètes au service de la performance.", 'Olivier Carré-Pierrat', 'DSI — Place du Marché'],
            ['experts', 4, "Partenaire exigeant et constructif, Gilles a contribué à des résultats concrets et mesurables.", 'Sébastien Alburquerque', 'Directeur des Opérations — ADP'],
            ['experts', 5, "Esprit vif, forte expertise technique RH et grande rigueur : Gilles dispose d'une capacité rare à décider avec justesse.", 'Hervé de Veyrac', 'Agent Général Allianz & Courtier'],
            ['experts', 6, "Manager pragmatique et fédérateur, Gilles sait accompagner, rassurer et faire grandir les équipes.", 'Manuel Fernandes', 'Directeur Région Centre Renault Trucks — Groupe Bernard'],
            ['experts', 7, "Gilles a à cœur de transmettre et de faire grandir ses collaborateurs dès leurs premières expériences professionnelles.", 'Alexia Audouard', 'Gestionnaire RH — Groupe Bernard'],
            ['experts', 8, "Manager accessible et positif, Gilles sait écouter, conseiller et aider dans des contextes RH exigeants.", 'Angélique Fruteau', 'Responsable RH Sud-Est — Intermarché'],
            ['experts', 9, "Gilles allie rigueur analytique et approche humaine, un équilibre essentiel pour un DRH de haut niveau.", 'Elodie Estrabol', 'Gestionnaire RH — Wincanton'],
            ['experts', 10, "Par son exigence et ses valeurs humaines, Gilles accompagne et fait grandir les professionnels RH, en leur transmettant une vision lucide et engagée du métier.", 'Marine Baconnier', 'Gestionnaire RH — Wincanton'],
        ];

        foreach ($data as [$category, $order, $quote, $authorName, $authorRole]) {
            $t = (new Temoignage())
                ->setCategory($category)
                ->setSortOrder($order)
                ->setQuote($quote)
                ->setAuthorName($authorName)
                ->setAuthorRole($authorRole)
                ->setVisible(true);
            $em->persist($t);
        }
    }

    // ─── Domaines d'intervention (pitch cards) ─────────────────────────────────

    private function loadPitchDomains(ObjectManager $em): void
    {
        $data = [
            [1, 'Restructurations & crises sociales',
                "PSE, fermetures de sites, procédures collectives, environnements sociaux dégradés. Zéro grève sur l'ensemble des interventions."],
            [2, 'Transformation & croissance',
                "Carve-out, intégrations post-acquisition, réorganisations, forte croissance organique. +750 collaborateurs intégrés en 18 mois."],
            [3, 'Structuration de la fonction RH',
                "Création et modernisation des DRH, déploiement SIRH, digitalisation, marque employeur. PME, ETI, groupes multi-sites."],
        ];
        foreach ($data as [$order, $title, $text]) {
            $em->persist((new PitchDomain())->setSortOrder($order)->setTitle($title)->setText($text));
        }
    }

    // ─── Réalisations (onglets) ────────────────────────────────────────────────

    private function loadRealisations(ObjectManager $em): void
    {
        $data = [
            [
                'sortOrder'       => 1,
                'tabLabel'        => 'Restructurations',
                'contextItems'    => [
                    "Restructurations avec et sans PSE",
                    "Fermetures de sites et procédures collectives",
                    "Environnements sociaux fortement dégradés",
                    "Droits d'alerte, RPS, autorités de tutelle",
                ],
                'bigNumber'       => '2 800',
                'bigNumberSuffix' => '+',
                'bigNumberLabel'  => 'départs pilotés au total',
                'resultItems'     => [
                    "800 départs sans PSE sécurisés",
                    "2 000 avec PSE, accords majoritaires",
                    "Fermeture Intermarché 130 lic. éco. en délais records",
                    "Liquidation Place du Marché — 2 200 collaborateurs",
                    "Zéro jour de grève sur toutes les restructurations",
                ],
            ],
            [
                'sortOrder'       => 2,
                'tabLabel'        => 'Croissance',
                'contextItems'    => [
                    "Croissance rapide, réorganisations post-acquisition",
                    "Séparations d'activités (carve-out)",
                    "Harmonisation multi-conventions collectives",
                ],
                'bigNumber'       => '+750',
                'bigNumberSuffix' => '',
                'bigNumberLabel'  => 'collaborateurs intégrés en 18 mois',
                'resultItems'     => [
                    "Intégrations sans rupture sociale",
                    "10+ conventions collectives harmonisées",
                    "+66% d'activité anticipé sur le pôle immobilier",
                    "Organisations RH alignées avec les enjeux business",
                ],
            ],
            [
                'sortOrder'       => 3,
                'tabLabel'        => 'Fonction RH',
                'contextItems'    => [
                    "PME, ETI et groupes multi-sites",
                    "Fonctions RH à structurer ou transformer",
                    "Digitalisation des processus RH",
                ],
                'bigNumber'       => '10k',
                'bigNumberSuffix' => '+',
                'bigNumberLabel'  => 'collaborateurs couverts par les SIRH déployés',
                'resultItems'     => [
                    "Création de directions RH from scratch",
                    "SIRH sur périmètre +10 000 collab. (Emil Frey)",
                    "Changements ADP, DECIDIUM, coffre-fort électronique",
                    "Structuration recrutement, GPEC, performance",
                ],
            ],
            [
                'sortOrder'       => 4,
                'tabLabel'        => 'Coaching',
                'contextItems'    => [
                    "Partenaire RH des dirigeants, COMEX et CODIR",
                    "Coaching individuel et collectif de managers",
                    "Accompagnement du changement en contexte sensible",
                ],
                'bigNumber'       => '30',
                'bigNumberSuffix' => '+',
                'bigNumberLabel'  => "ans d'expérience en gestion RH",
                'resultItems'     => [
                    "Prise de décision sécurisée pour les dirigeants",
                    "Montée en maturité managériale des équipes",
                    "Coaching nouveaux membres CODIR (Groupe Bernard)",
                    "Meilleure adhésion aux projets de transformation",
                ],
            ],
        ];

        foreach ($data as $d) {
            $r = (new Realisation())
                ->setSortOrder($d['sortOrder'])
                ->setTabLabel($d['tabLabel'])
                ->setContextItems($d['contextItems'])
                ->setBigNumber($d['bigNumber'])
                ->setBigNumberSuffix($d['bigNumberSuffix'])
                ->setBigNumberLabel($d['bigNumberLabel'])
                ->setResultItems($d['resultItems']);
            $em->persist($r);
        }
    }

    // ─── Méthode (étapes) ──────────────────────────────────────────────────────

    private function loadMethodeSteps(ObjectManager $em): void
    {
        $data = [
            [1, 'J+30', 'Compréhension & prise de contrôle',
                "Contexte, enjeux humains et sociaux. Contact équipes, partenaires sociaux, direction. Mise sous contrôle immédiate des sujets sensibles."],
            [2, 'J+60', 'Structuration & sécurisation',
                "Structuration des priorités, sécurisation du dialogue social. Accompagnement des décisions de transformation."],
            [3, 'J+90', 'Mise en œuvre & développement',
                "Bases RH robustes posées. Alignées avec les enjeux futurs. Organisation pérenne, autonome, performante."],
        ];
        foreach ($data as [$order, $day, $tag, $desc]) {
            $em->persist((new MethodeStep())->setSortOrder($order)->setDay($day)->setTag($tag)->setDescription($desc));
        }
    }

    // ─── Sources publiques ─────────────────────────────────────────────────────

    private function loadSources(ObjectManager $em): void
    {
        $data = [
            [1, "L'Argus",                    "Groupe Bernard – stratégie et gouvernance",                         'https://www.largus.fr/pros/actualite-automobile/gilles-messier-prend-la-direction-generale-du-groupe-bernard-5763384.html'],
            [2, "Journal Officiel",            "Nomination de conseillers prud'hommes (p. 63)",                    'https://www.unsa.org/IMG/pdf/jo9122022nominations_conseillers_prud_hommes.pdf'],
            [3, "Min. Transition écologique",  "États généraux du transport (p. 34)",                             'https://portail.documentation.developpement-durable.gouv.fr/exl-php/document-affiche/mte_recherche_avancee/OUVRE_DOC/4584?fic=itmouv00113840.pdf'],
            [4, "Supply Chain Magazine",       "Commission sociale TLF",                                          'https://supplychainmagazine.fr/nl/2012/trois-nouvelles-tetes-chez-tlf/'],
            [5, "Wikipédia",                   "Groupe Toupargel / Place du Marché – contexte économique",        'https://fr.wikipedia.org/wiki/Groupe_Toupargel#Difficult%C3%A9s'],
        ];
        foreach ($data as [$order, $badge, $title, $url]) {
            $em->persist((new Source())->setSortOrder($order)->setBadge($badge)->setTitle($title)->setUrl($url)->setVisible(true));
        }
    }
}
