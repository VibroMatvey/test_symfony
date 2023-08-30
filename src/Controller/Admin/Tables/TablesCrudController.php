<?php

namespace App\Controller\Admin\Tables;

use App\Entity\Tables;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class TablesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Tables::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Стол')
            ->setEntityLabelInPlural('Столы');
    }

    public function configureFields(string $pageName): iterable
    {
        $id = IdField::new('id');
        $num = IntegerField::new('num', 'Номер стола');
        $description = TextField::new('description', 'Описание');
        $maxGuests = IntegerField::new('maxGuests', 'Макс количество человек');
        $guestsDef = IntegerField::new('guestsDef', 'Гостей');
        $guestsNow = IntegerField::new('guestsNow', 'Присутствует гостей');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $num, $description, $maxGuests, $guestsDef, $guestsNow];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$id, $num, $description, $maxGuests, $guestsDef, $guestsNow];
        } else {
            return [$num, $description, $maxGuests];
        }
    }
}
