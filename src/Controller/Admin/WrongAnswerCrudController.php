<?php

namespace App\Controller\Admin;

use App\Entity\WrongAnswer;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class WrongAnswerCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return WrongAnswer::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('text'),
            AssociationField::new('question')->autocomplete(),
        ];
    }
}
