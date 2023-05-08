<?php

namespace App\Controller\Admin;

use App\Entity\RightAnswer;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class RightAnswerCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return RightAnswer::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('text'),
            AssociationField::new('question')->autocomplete(),
        ];
    }
}
