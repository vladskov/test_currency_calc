<?php

namespace App\Form;

use App\Entity\Role;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;


class RoleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        	->add('name', null, array( 'label' => 'Введите название роли', 'label_attr' => array('class' => 'form_label') ))
       		->add('code', null, array( 'label' => 'Введите код роли', 'label_attr' => array('class' => 'form_label') ))
       		->add( 'save', SubmitType::class, array( 'label' => 'Сохранить', 'attr' => array( 'class' => 'btn btn-left btn-success' )  ))
       		->add('cancel', ButtonType::class, array( 'label' => 'Назад', 'attr' => array( 'onclick' => 'document.location.href = "/admin/role"', 'class' => 'btn btn-left btn-warning mt-1' ) ) )
	        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Role::class,
        ]);
    }
}
