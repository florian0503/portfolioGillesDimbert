<?php

namespace App\Controller\Admin;

use App\Entity\Experience;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

class ExperienceCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Experience::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Expérience')
            ->setEntityLabelInPlural('Expériences (Parcours)')
            ->setDefaultSort(['sortOrder' => 'ASC']);
    }

    public function configureFields(string $pageName): iterable
    {
        yield IntegerField::new('sortOrder', 'N° (ordre)');
        yield TextField::new('period', 'Période')->setHelp('Ex: 2020–2025');
        yield ChoiceField::new('type', 'Type')->setChoices([
            'CDI'        => 'cdi',
            'Transition' => 'transition',
            'CDD'        => 'cdd',
        ]);
        yield TextField::new('company', 'Entreprise');
        yield TextField::new('companySubtitle', 'Sous-titre entreprise')->setRequired(false);
        yield TextField::new('role', 'Poste');
        yield TextareaField::new('context', 'Contexte')
            ->setHelp('Taille, secteur, périmètre…')
            ->setNumOfRows(2);
        yield TextField::new('logo', 'Fichier logo')
            ->setHelp('Nom du fichier dans /logos/, ex: wincanton.png')
            ->setRequired(false);
        yield TextareaField::new('tagsText', 'Tags')
            ->setHelp("Un tag par ligne.\nEx:\nTransition\n700 sal.\nPSE")
            ->onlyOnForms()
            ->setNumOfRows(4);
        yield TextareaField::new('externalLinksText', 'Liens externes')
            ->setHelp("Un lien par ligne : Label|https://url.com")
            ->onlyOnForms()
            ->setNumOfRows(3);
        yield TextareaField::new('detailGroupsText', 'Détails du poste')
            ->setHelp("Titre de groupe (sans tiret), puis les items avec « - » devant.\n\nEx:\nRéorganisation & social\n- Structuration équipe RH\n- −190 postes en 6 mois\n\nBuild & culture\n- Item A")
            ->onlyOnForms()
            ->setNumOfRows(18);
    }

    public function persistEntity(EntityManagerInterface $em, mixed $entity): void
    {
        // Pour une nouvelle entité, re-parser suffit — Doctrine fait un INSERT complet
        $entity->setDetailGroupsText($entity->getDetailGroupsText());
        parent::persistEntity($em, $entity);
    }

    public function updateEntity(EntityManagerInterface $em, mixed $entity): void
    {
        // Re-parse le texte
        $entity->setDetailGroupsText($entity->getDetailGroupsText());
        // Forcer la détection du changeset JSON sur SQLite (entité déjà managée)
        $em->getUnitOfWork()->recomputeSingleEntityChangeSet(
            $em->getClassMetadata(Experience::class),
            $entity
        );
        parent::updateEntity($em, $entity);
    }
}
