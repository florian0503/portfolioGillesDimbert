<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use Doctrine\ORM\EntityManagerInterface;

class UserCrudController extends AbstractCrudController
{
    public function __construct(private UserPasswordHasherInterface $hasher) {}

    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud->setEntityLabelInSingular('Utilisateur')
                    ->setEntityLabelInPlural('Utilisateurs');
    }

    public function configureFields(string $pageName): iterable
    {
        yield EmailField::new('email', 'Email');
        yield TextField::new('plainPassword', 'Mot de passe')
            ->onlyOnForms()
            ->setRequired($pageName === Crud::PAGE_NEW);
        yield ArrayField::new('roles', 'Rôles');
    }

    public function persistEntity(EntityManagerInterface $em, mixed $entity): void
    {
        $this->hashPassword($entity);
        parent::persistEntity($em, $entity);
    }

    public function updateEntity(EntityManagerInterface $em, mixed $entity): void
    {
        $this->hashPassword($entity);
        parent::updateEntity($em, $entity);
    }

    private function hashPassword(User $user): void
    {
        if ($plain = $user->getPlainPassword()) {
            $user->setPassword($this->hasher->hashPassword($user, $plain));
        }
    }
}
