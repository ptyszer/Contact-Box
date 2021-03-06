<?php
namespace ContactBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddressType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->setMethod('POST')
            ->add('city', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('street', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('house', NumberType::class, ['attr' => ['class' => 'form-control']])
            ->add('flat', IntegerType::class, ['attr' => ['class' => 'form-control'],'required' => false])
            ->add('type', TextType::class, ['attr' => ['class' => 'form-control'],'required' => false])
            ->add('save', SubmitType::class, ['label' => 'Add address', 'attr' => ['class' => 'btn btn-primary']]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ContactBundle\Entity\Address'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'contactbundle_address';
    }
}