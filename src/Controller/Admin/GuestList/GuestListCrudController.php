<?php

namespace App\Controller\Admin\GuestList;

use App\Entity\GuestList;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class GuestListCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return GuestList::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Гость')
            ->setEntityLabelInPlural('Гости')
            ->setPageTitle(Crud::PAGE_NEW, 'Добавление гостя')
            ->setPageTitle(Crud::PAGE_EDIT, 'Изменение гостя');
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->update(Crud::PAGE_INDEX, Action::NEW, function (Action $action) {
                return $action->setLabel('Добавить гостя');
            });
    }


    public function configureFields(string $pageName): iterable
    {
        $id = IdField::new('id');
        $isPresent = BooleanField::new('isPresent', 'Присутствие');
        $name = TextField::new('name', 'ФИО');
        $tables = AssociationField::new('tables', 'Стол');
//test2
        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $isPresent, $name, $tables];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$id, $isPresent, $name, $tables];
        } else {
            return [$isPresent, $name, $tables];
        }
    }

}
