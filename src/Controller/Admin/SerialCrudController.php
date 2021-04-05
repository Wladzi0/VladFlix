<?php

namespace App\Controller\Admin;

use App\Entity\Serial;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class SerialCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Serial::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('name')->setRequired(true),
            TextField::new('country')->setRequired(true),
            DateField::new('yearStart')->setRequired(true),
            DateField::new('yearFinish'),
            ChoiceField::new('ageCategory')->setChoices(array(
                'Kid' => -1,
                'Teenager' => 0,
                'Adult' => 1))->setRequired(true),
            AssociationField:: new('categories')->setRequired(true),
            AssociationField:: new('season')->setRequired(true),
        ];
    }

}
