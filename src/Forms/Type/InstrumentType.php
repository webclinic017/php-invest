<?php

namespace App\Forms\Type;

use App\Entity\Asset;
use App\Entity\Currency;
use App\Entity\Instrument;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class InstrumentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('isin', TextType::class, ['label' => 'ISIN', 'required' => false])
            ->add('name', TextType::class)
            ->add('type', ChoiceType::class, ['choices' => [
                'Direct' => [
                    'Underlying' => Instrument::TYPE_UNDERLYING,
                    'CFD' => Instrument::TYPE_CFD,
                ],
                'Derivative' => [
                    'Knock-Out' => Instrument::TYPE_KNOCKOUT,
                    'Option' => Instrument::TYPE_OPTION,
                    'Structured' => Instrument::TYPE_STRUCTURED,
                ],
                ]])
            ->add('underlying', EntityType::class, ['class' => Asset::class])
            ->add('currency', EntityType::class, ['class' => Currency::class])
            ->add('issuer', TextType::class)
            ->add('notes', TextareaType::class, ['required' => false])
            ->add('save', SubmitType::class, ['label' => 'Submit', 'attr' => ['class' => 'btn btn-primary']])
        ;
    }
}