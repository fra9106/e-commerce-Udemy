<?php

namespace App\Controller\Admin;

use App\Entity\Purchase;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;

class PurchaseCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Purchase::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('user.fullName', 'Client'),
            TextField::new('carrierName', 'Carrier Name'),
            MoneyField::new('CarrierPrice', 'Shipping')->setCurrency('EUR'),
            MoneyField::new('subTotalHt', 'SubTotal HT')->setCurrency('EUR'),
            MoneyField::new('subTotalTtc', 'SubTotal TTC')->setCurrency('EUR'),
            BooleanField::new('isPaid')
        ];
    }
    
}
