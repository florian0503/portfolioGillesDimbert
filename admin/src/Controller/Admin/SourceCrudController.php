<?php

namespace App\Controller\Admin;

use App\Entity\Source;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

class SourceCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Source::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Source publique')
            ->setEntityLabelInPlural('Sources publiques')
            ->setDefaultSort(['sortOrder' => 'ASC']);
    }

    public function configureFields(string $pageName): iterable
    {
        yield IntegerField::new('sortOrder', 'Ordre');
        yield TextField::new('badge', 'Badge')->setHelp("Ex: L'Argus, Journal Officiel");
        yield TextField::new('title', 'Titre du lien');
        yield TextField::new('url', 'URL');
        yield BooleanField::new('visible', 'Visible');
    }
}
