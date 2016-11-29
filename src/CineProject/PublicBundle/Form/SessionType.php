<?php

namespace CineProject\PublicBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SessionType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date')
            ->add('movie', EntityType::class, array(
                'class' => 'CineProjectPublicBundle:Movie',
                'choice_label' => 'title'
            ))
            ->add('cinema', EntityType::class, array(
                'class' => 'CineProjectPublicBundle:Cinema',
                'choice_label' => 'name'
            ));


    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CineProject\PublicBundle\Entity\Session'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'cineproject_publicbundle_session';
    }


}
