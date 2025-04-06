<?php

namespace App\Form;

use App\Entity\Produit;
use App\Entity\User;
use App\Entity\Categorie;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use App\Form\ImageType;


class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('description')
            ->add('categorie')
            ->add('pays')
            ->add('disponible')
            ->add('stock')
            ->add('etat', ChoiceType::class, [
                'choices' => [
                    'Nouveau' => 'Nouveau',
                    'Bonne occasion' => 'Bonne occasion',
                ],
                'expanded' => false, // Choix sous forme de liste déroulante
                'multiple' => false, // Un seul choix possible
            ])
            //->add('etat')
            //->add('dateCreation', null, [
              //  'widget' => 'single_text',
           // ])
            //->add('prix')
            ->add('prix', NumberType::class, [
                'scale' => 2, // 2 décimales après la virgule
                'attr' => [
                    'step' => '0.01', // Permet de saisir des valeurs décimales
                    'min' => '0', // Le prix ne peut pas être négatif
                ],
            ])
            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'id',
            ])
           // src/Form/ProduitType.php

->add('categorie', EntityType::class, [
    'class' => Categorie::class,
    'choice_label' => 'nom', // Affiche le nom de la catégorie dans la liste déroulante
    'placeholder' => 'Choisissez une catégorie', // Optionnel
    'required' => true,
])

->add('images', CollectionType::class, [
    'entry_type' => ImageType::class,
    'entry_options' => ['label' => false],
    'allow_add' => true,
    'allow_delete' => true,
    'by_reference' => false,
    'label' => 'Images du produit',
    'required' => false,
    'prototype' => true,
]);
           //->add('images', FileType::class, [
           // 'label' => 'Images du produit',
           // 'multiple' => true,
           // 'mapped' => false, // Ce champ n'est pas lié directement à l'entité
           // 'required' => false,
           //]);
           
        }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}
