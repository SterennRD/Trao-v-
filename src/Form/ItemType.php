<?php

namespace App\Form;

use App\Entity\Item;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ItemType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('photo')
            ->add('description')
            ->add('address')
            ->add('city')
            ->add('dateBegin')
            ->add('dateEnd')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('category')
            ->add('county')
            ->add('status')
            ->add('user')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Item::class,
        ]);
    }
}
