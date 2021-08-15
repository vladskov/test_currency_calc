<?php

namespace App\Form;

use App\Entity\Page;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;

class PageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        	->add('title', null, array( 'label' => 'Название страницы', 'label_attr' => array('class' => 'form_label') ))
        	->add('link', null, array( 'label' => 'Ссылка страницы', 'label_attr' => array('class' => 'form_label') ))
        	->add('content', null, array( 'label' => 'Содержимое страницы', 'label_attr' => array('class' => 'form_label') ))
        	->add('is_active', CheckboxType::class, array( 'label' => 'Страница активна', "required" => false, 'label_attr' => array('class' => 'form_label') ))
        	->add('is_default_admin', CheckboxType::class, array( 'label' => 'По умолчанию для админа', "required" => false, 'label_attr' => array('class' => 'form_label') ))
        	->add('is_default_user', CheckboxType::class, array( 'label' => 'По умолчанию для пользователя', "required" => false, 'label_attr' => array('class' => 'form_label') ))
        	->add( 'save', SubmitType::class, array( 'label' => 'Сохранить', 'attr' => array( 'class' => 'btn btn-left btn-success' ) ))
        	->add('cancel', ButtonType::class, array( 'label' => 'Назад', 'attr' => array( 'onclick' => 'document.location.href = "/admin/page"', 'class' => 'btn btn-left btn-warning mt-1' ) ) )
        	;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Page::class,
        ]);
    }
}
