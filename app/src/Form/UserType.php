<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;



class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        	->add( 'email', EmailType::class, array( 'label' => 'Введите email', 'label_attr' => array('class' => 'form_label') ))
        	->add('plain_password', RepeatedType::class, array( 'type' => PasswordType::class,'first_options' => array( 'label' => 'Пароль', 'label_attr' => array('class' => 'form_label') ), 'second_options' => array( 'label' => 'Повтор Пароля', 'label_attr' => array('class' => 'form_label') ) ) )
        	->add('is_active', CheckboxType::class, array( 'label' => 'Активный', 'required' => false, 'label_attr' => array('class' => 'form_label') ))
        	->add( 'save', SubmitType::class, array( 'label' => 'Сохранить', 'attr' => array( 'class' => 'btn btn-left btn-success' ) ) )
        	->add('cancel', ButtonType::class, array( 'label' => 'Назад', 'attr' => array( 'onclick' => 'document.location.href = "/admin/user"', 'class' => 'btn btn-left btn-warning mt-1' ) ) )
        	;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
