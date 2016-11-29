<?php

namespace CineProject\PublicBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DirectorType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName')
            ->add('lastName')
            ->add('birthDate', DateType::class, array(
                'widget' => 'single_text',
                'format' => 'dd-MM-yyyy'
            ))
            ->add('biography')
            ->add('image', new ImageType(), array(
                'required' => false
            ))
            ->add('movies', EntityType::class, array(
                'class' => 'CineProjectPublicBundle:Movie',
                'choice_label' => 'title',
                'multiple' => true
            ));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CineProject\PublicBundle\Entity\Director'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'cineproject_publicbundle_director';
    }


}
