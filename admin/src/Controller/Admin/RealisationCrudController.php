<?php

namespace App\Controller\Admin;

use App\Entity\Realisation;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

class RealisationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Realisation::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Réalisation (onglet)')
            ->setEntityLabelInPlural('Réalisations')
            ->setDefaultSort(['sortOrder' => 'ASC']);
    }

    public function configureFields(string $pageName): iterable
    {
        yield IntegerField::new('sortOrder', 'Ordre');
        yield TextField::new('tabLabel', 'Libellé onglet');
        yield TextareaField::new('contextItemsText', 'Contextes gérés')
            ->setHelp('Une ligne par élément.')
            ->onlyOnForms()
            ->setNumOfRows(5);
        yield TextField::new('bigNumber', 'Grand chiffre')->setHelp('Ex: 2 800 ou +750');
        yield TextField::new('bigNumberSuffix', 'Suffixe')->setHelp('"+" ou laisser vide');
        yield TextField::new('bigNumberLabel', 'Libellé du chiffre')->setHelp('Ex: départs pilotés au total');
        yield TextareaField::new('resultItemsText', 'Résultats / impacts')
            ->setHelp('Une ligne par élément.')
            ->onlyOnForms()
            ->setNumOfRows(6);
    }
}
