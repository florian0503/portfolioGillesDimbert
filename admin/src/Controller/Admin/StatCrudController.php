<?php

namespace App\Controller\Admin;

use App\Entity\Stat;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

class StatCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Stat::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Statistique')
            ->setEntityLabelInPlural('Statistiques')
            ->setDefaultSort(['sortOrder' => 'ASC']);
    }

    public function configureFields(string $pageName): iterable
    {
        yield IntegerField::new('sortOrder', 'Ordre');
        yield IntegerField::new('target', 'Valeur cible');
        yield TextField::new('suffix', 'Suffixe')->setHelp('"+" ou "" pour zéro');
        yield TextField::new('label', 'Libellé')->setHelp('Ex: ans d\'expérience\nen groupes & ETI');
    }
}
