<?php
// src/AppBundle/Form/edit_sampleType.php 

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use AppBundle\Repository\DsampleRepository;
use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\Dsample;


/**
 * DsampleType
 *
 * @ORM\Table(name="dsample", uniqueConstraints={@ORM\UniqueConstraint(name="dsample_unique", columns={"idcollection", "idsample"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DsampleRepository")
 */

 class edit_sampleType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
		$pattern = 'A%';
		
        $builder
			/*->add('idcollection')->add('idsample')->add('museumnum')->add('museumlocation')->add('boxnumber')->add('sampledescription')->add('weight')->add('quantity')
			->add('size')->add('dimentioncode')->add('quality')->add('slimplate')->add('chemicalanalysis')->add('holotype')->add('paratype')->add('radioactivity')->add('loaninformation')
			->add('securitylevel')->add('varioussampleinfo')			
			->add('fieldnum', EntityType::class, array(
			'class'         => 'AppBundle:Dsample',
			'choice_label'  => 'fieldnum',
			'multiple'      => true,
			'query_builder' => function( DsampleRepository $repository) use($pattern) {
								return $repository->getLikeQueryBuilder($pattern);
			//'query_builder' => function(EntityRepository $repository) use($pattern) {
							// return $repository->createQueryBuilder('u')    ->orderBy('u.fieldnum', 'ASC');
								}
			))*/
			->add('searchnum',   TextType::class, array('mapped' => false, 'required' => false))
			->add('search', ButtonType::class, array('label' => 'Search sample'))
			/*->add('save', SubmitType::class, array('label' => 'Search sample'))*/ ;
    }
	
	/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Dsample' /*Dsample::class*/
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_dsample';
    }
}