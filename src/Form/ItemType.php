<?php

namespace App\Form;

use App\Entity\Item;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class ItemType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array('label' => 'Titre'))
            ->add('photo', FileType::class)
            ->add('description', TextType::class)
            ->add('dateBegin', DateType::class, array('label' => 'Trouvé le'))
            ->add('category')
            ->add('address', TextType::class, array('label' => 'Adresse'))
            ->add('city', TextType::class, array('label' => 'Ville'))
            ->add('county')
            ->add('status')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Item::class,
        ));
    }
}
