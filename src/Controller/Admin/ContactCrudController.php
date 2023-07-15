<?php

namespace App\Controller\Admin;

use App\Entity\Contact;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ContactCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Contact::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural('Applications')
            ->setEntityLabelInSingular('Application')
            ->setPageTitle("index", "Applications | Synexta")
            ->setPaginatorPageSize(10);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->hideOnForm(),
            TextField::new('lastName', 'Nom'),
            TextField::new('firstName', 'Prénom'),
            EmailField::new('email'),
            BooleanField::new('isAccepted', 'Accepté'),
            DateField::new('createdAt', 'Créé le')
                ->hideOnForm(),
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL);
    }
}
