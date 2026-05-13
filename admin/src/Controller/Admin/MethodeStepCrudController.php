<?php

namespace App\Controller\Admin;

use App\Entity\MethodeStep;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

class MethodeStepCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return MethodeStep::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Étape méthode')
            ->setEntityLabelInPlural('Méthode (étapes)')
            ->setDefaultSort(['sortOrder' => 'ASC']);
    }

    public function configureFields(string $pageName): iterable
    {
        yield IntegerField::new('sortOrder', 'Ordre');
        yield TextField::new('day', 'Jalon')->setHelp('Ex: J+30');
        yield TextField::new('tag', 'Titre étape');
        yield TextareaField::new('description', 'Description');
    }
}
