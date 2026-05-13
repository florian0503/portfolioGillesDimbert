<?php

namespace App\Controller\Admin;

use App\Entity\ContactInfo;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;

class ContactInfoCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ContactInfo::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Infos de contact')
            ->setEntityLabelInPlural('Infos de contact');
    }

    public function configureActions(Actions $actions): Actions
    {
        // Entité singleton : pas besoin de créer / supprimer
        return $actions
            ->disable(Action::NEW, Action::DELETE);
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('phone', 'Téléphone')->setHelp('Ex: 06 08 46 85 63');
        yield TextField::new('email', 'Email');
        yield TextField::new('linkedin', 'URL LinkedIn');
        yield TextField::new('location', 'Localisation')->setHelp('Ex: Lyon · Mobilité nationale');
        yield TextField::new('availability', 'Disponibilité')->setHelp('Ex: juin 2026');
        yield TextField::new('extraInfo', 'Info complémentaire')->setHelp('Ex: Juge prud\'homal depuis 2002');
    }
}
