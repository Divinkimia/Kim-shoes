<?php

namespace App\Form;

use App\Entity\Product;
use App\Entity\SubCategory;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
                ->add('description')
            ->add('price')
            ->add('stock')
            ->add('image',FileType::class,[
                'label'=>'Image du produit :',
                'required' => false,
                'constaints'=>[
                    new File ([
                        "maxSize"=>"1024k",
                        'extension'=> ['jpg','png','jpeg'],
                    'entesionsMessage'=> 'Votre image doit etre dans un format valide (.jpg, .png, .jpeg) !',
                    'maxSizeMessage'=> 'Votre image doit faire moins de 1024 !'
                    ])
                ]
            ])

            ->add('subCathgories',EntityType::class,[
                'class'=>SubCategory::class,
                'choice_label' => 'name',
                'multiple' => true, 
            ])
            
        ;
        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
