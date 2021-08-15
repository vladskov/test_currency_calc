<?php

namespace App\Form;

use App\Entity\Menu;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;

class MenuType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
	        ->add('name', null, array( 'label' => 'Введите название меню', 'label_attr' => array('class' => 'form_label') ))
	        ->add('link', null, array( 'label' => 'Введите ссылку', 'label_attr' => array('class' => 'form_label') ))
	        ->add('order_priority', null, array( 'label' => 'Введите порядок следования', 'label_attr' => array('class' => 'form_label') ))
	        ->add('is_admin', CheckboxType::class, array( 'label' => 'Административное меню', 'required' => false, 'label_attr' => array('class' => 'form_label') ))
	        ->add('is_active', CheckboxType::class, array( 'label' => 'Активный', 'required' => false, 'label_attr' => array('class' => 'form_label') ))
	        ->add( 'save', SubmitType::class, array( 'label' => 'Сохранить', 'attr' => array( 'class' => 'btn btn-left btn-success' ) ))
	        ->add('cancel', ButtonType::class, array( 'label' => 'Назад', 'attr' => array( 'onclick' => 'document.location.href = "/admin/menu"', 'class' => 'btn btn-left btn-warning mt-1' ) ) )
	        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Menu::class,
        ]);
    }
}
