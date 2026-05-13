<?php

namespace App\Controller\Admin;

use App\Entity\Expertise;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

class ExpertiseCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Expertise::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Expertise')
            ->setEntityLabelInPlural('Expertises')
            ->setDefaultSort(['sortOrder' => 'ASC']);
    }

    public function configureFields(string $pageName): iterable
    {
        yield IntegerField::new('sortOrder', 'Ordre');
        yield TextField::new('title', 'Titre');
        yield TextareaField::new('description', 'Description');
        yield BooleanField::new('visible', 'Visible');
    }
}
