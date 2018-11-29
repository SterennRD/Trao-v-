<?php

namespace App\Form;

use App\Entity\Item;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class ItemType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array('label' => 'Titre'))
            ->add('photo', FileType::class, array('required' => false))
            ->add('description', TextareaType::class, array('required' => false))
            ->add('dateBegin', DateType::class, array(
                'label' => 'Date',
                'widget' => 'single_text'
            ))
            ->add('category')
            ->add('address', TextType::class, array('label' => 'Adresse', 'required' => false))
            ->add('city', TextType::class, array('label' => 'Ville'))
            ->add('county')
        ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Item::class,
        ));
    }
}
