<?php

namespace App\Controller\Admin;

use App\Entity\Film;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TimeField;

class FilmCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Film::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('name')->setRequired(true),
            TextField::new('country')->setRequired(true),
            DateField::new('year')->setRequired(true),
            ChoiceField::new('ageCategory')->setChoices(array(
                'Kid' => 'null',
                'Teenager' => 0,
                'Adult' => 1))->setRequired(true),
            AssociationField:: new('categories')->setRequired(true),
            AssociationField:: new('file')->setRequired(true),
        ];
    }

}
