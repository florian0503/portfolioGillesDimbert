<?php

namespace App\Controller\Admin;

use App\Entity\Temoignage;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

class TemoignageCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Temoignage::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Témoignage')
            ->setEntityLabelInPlural('Témoignages')
            ->setDefaultSort(['category' => 'ASC', 'sortOrder' => 'ASC']);
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextareaField::new('quote', 'Citation');
        yield TextField::new('authorName', 'Auteur');
        yield TextField::new('authorRole', 'Poste / Organisation');
        yield ChoiceField::new('category', 'Catégorie')->setChoices([
            'Directions & COMEX' => 'directions',
            'Dialogue social & Institutions' => 'dialogue_social',
            'Experts & Équipes' => 'experts',
        ]);
        yield IntegerField::new('sortOrder', 'Ordre');
        yield BooleanField::new('visible', 'Visible');
    }
}
