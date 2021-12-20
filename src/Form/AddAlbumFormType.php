<?php

namespace App\Form;

use App\Entity\Album;
use App\Entity\Img;
use App\Form\Type\Dropzone\DropzoneType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class AddAlbumFormType
 * @package Add\Form
 */

class AddAlbumFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class,[
                'label' => 'Введите название мероприятия: ',
                'attr' => array('class' => 'input')
            ])
            ->add('date_publication', DateType::class, [
                'label' => 'Введите дату мероприятия: ',
                'label_attr' => array('class' => 'date_input'),
                'attr' => array('style' => 'margin: 10px 0 20px 0;'),
                'widget' => 'single_text'
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Добавте описание: '
            ])
            ->add('active', CheckboxType::class, [
                'label' => 'Отображение альбома: ',
                'label_attr' => array('class' => 'check_box', 'style' => 'margin-bottom: 20px;'),
                'attr' => array('style' => 'margin: 0; margin: 2px 0 0 7px;'),
                'required' => false
            ])
            ->add('images', DropzoneType::class, [
                'label' => 'Добавиление фотографий',
                'attr' => [
                    'id' => 'id_img',

                ],
                'maxFiles' => 50,
                'mapped' => false,

            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Добавить',
                'attr' => ['class' => 'button',]
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Album::class,
        ]);
    }
}
