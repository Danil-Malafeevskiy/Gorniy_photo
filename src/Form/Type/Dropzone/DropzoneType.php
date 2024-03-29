<?php

namespace App\Form\Type\Dropzone;

use App\Repository\ImgRepository;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;

class DropzoneType extends AbstractType
{

    public function __construct(
        private ImgRepository $imgRepository
    ){
    }

    final public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'dropzone',
            CollectionType::class,
            [
                'entry_type' => HiddenType::class,
                'label' => false,
                'allow_add' => true,
                'allow_delete' => true,
                'attr' => [
                    'class' => 'dropzone',
                    'id' => 'dropzone',
                    'action' => '/img/upload',
                ],
            ]
        )->addModelTransformer(new DropzoneTransformer($this->imgRepository));

        parent::buildForm($builder, $options); //
    }

    final public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'once' => false,
            'maxFiles' => 50,
            'addRemoveLinks' => false,
        ]);

        parent::configureOptions($resolver);
    }

    /**
     * @param FormView $view
     * @param FormInterface $form
     * @param array $options
     */

    final public function buildView(FormView $view, FormInterface $form, array $options)
    {
        /** @var FormView $f */
        $f = $view->vars['form'];
        $view->vars['formName'] = $f->parent->vars['name'];
        $view->vars['id'] = $options['attr']['id'];
        $view->vars['maxFiles'] = $options['maxFiles'];
        $view->vars['img'] = [];

        parent::buildView($view, $form, $options);
    }
}
