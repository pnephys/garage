<?php

namespace App\Form;

use App\Entity\Ad;
use App\Form\ImageType;
use App\Form\ApplicationType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class AnnonceType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('marque',TextType::class, $this->getConfiguration('marque','marque de la voiture')
            )
            ->add('slug', TextType::class, $this->getConfiguration('slug','Adresse web (automatique)',[
                'required' => false //rendre un champ non oligatoire
            ]))
            ->add('modele', TextType::class, $this->getConfiguration('modele','modele de la voiture'))
            ->add('CoverImage', UrlType::class, $this->getConfiguration('URL de l\'image','Donnez l\'adresse de votre image'))
            ->add('price', MoneyType::class, $this->getConfiguration('price','mettre le prix de voiture'))
            ->add('km', TextType::class, $this->getConfiguration('km','mettre le nombre de kilomètre'))
            ->add('NbProprio', NumberType::class, $this->getConfiguration('NbProprio','nombre de propriétaire'))
            ->add('cylindre', NumberType::class, $this->getConfiguration('cylindre','nombre de cylindre'))
            ->add('puissance', NumberType::class, $this->getConfiguration('puissance','puissance de la voiture'))
            ->add('carburant', TextType::class, $this->getConfiguration('carburant','type de carburant'))
            ->add('Pcirculation', NumberType::class, $this->getConfiguration('Pcirculation','première mise en circulation'))
            ->add('transmission', TextType::class, $this->getConfiguration('transmission','type de transmission'))
            ->add('description', TextType::class, $this->getConfiguration('description','description de la voiture'))
            ->add('options', TextareaType::class, $this->getConfiguration('options','les options de la voiture'))
            ->add(
                'images',
                CollectionType::class,
                [
                    'entry_type' => ImageType::class,
                    'allow_add' => true, // permet d'ajouter de nouveaux éléments et ajouter un data_prototype
                    'allow_delete' => true
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ad::class,
        ]);
    }
}
