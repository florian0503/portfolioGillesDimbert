<?php

namespace App\Controller\Admin;

use App\Entity\PitchDomain;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

class PitchDomainCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return PitchDomain::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular("Domaine d'intervention")
            ->setEntityLabelInPlural("Domaines d'intervention")
            ->setDefaultSort(['sortOrder' => 'ASC']);
    }

    public function configureFields(string $pageName): iterable
    {
        yield IntegerField::new('sortOrder', 'Ordre');
        yield TextField::new('title', 'Titre');
        yield TextareaField::new('text', 'Description');
    }
}
