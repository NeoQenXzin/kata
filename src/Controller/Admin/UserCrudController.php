<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }


    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->hideOnForm();
        yield AssociationField::new('user_books')->hideOnForm();
        yield TextField::new('username');
        yield TextField::new('name');
        yield EmailField::new('email');
        yield TextField::new('password');
        yield ArrayField::new('roles');
    }


    // public function configureCrud(Crud $crud): Crud
    // {
    //     return $crud
    //         ->setEntityLabelInSingular('User Book')
    //         ->setEntityLabelInPlural('User Books')
    //         ->setSearchFields(['username', 'name', 'email'])
    //         ->setDefaultSort(['id' => 'DESC']);
    // }

    // public function configureFilters(Filters $filters): Filters
    // {
    //     return $filters
    //         ->add(EntityFilter::new('book'));
    // }
}
