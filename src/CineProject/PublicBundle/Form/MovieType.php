<?php

namespace CineProject\PublicBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MovieType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, array(
                'required' => false
            ))
            ->add('description')
            ->add('releaseDate')
            //->add('visible');
            ->add('visible', ChoiceType::class, array(
                'choices' => array('Non' => false, 'Oui' => true),
                // always include this
                'choices_as_values' => true,
                'expanded' => true,
                'multiple' => false,
            ))
            ->add('actors', EntityType::class, array(
                'class' => 'CineProjectPublicBundle:Actor',
                'choice_label' => 'fullName',
                'multiple' => true
            ));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CineProject\PublicBundle\Entity\Movie'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'cineproject_publicbundle_movie';
    }


}
