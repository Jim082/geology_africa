<?php
// src/AppBundle/Form/search_sampleType.php 

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use AppBundle\Repository\DsampleRepository;
//use AppBundle\Repository\codecollectionRepository;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use AppBundle\Entity\Dsample;
//use AppBundle\Entity\Codecollection;


/**
 * DsampleType
 *
 * @ORM\Table(name="dsample", uniqueConstraints={@ORM\UniqueConstraint(name="dsample_unique", columns={"idcollection", "idsample"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DsampleRepository")
 */

 class search_sampleType extends AbstractType
{
	private $em;
    
    /**
     * The Type requires the EntityManager as argument in the constructor. It is autowired
     * in Symfony 3.
     * 
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
		$pattern = 'sample%';
		
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
			
			->add('searchnum',   TextType::class, array('mapped' => false, 'required' => false));
			/*->add('search', ButtonType::class, array('label' => 'Search sample'))
			->add('save', SubmitType::class, array('label' => 'Search sample'))*/ 
			
       // $builder->addEventListener(FormEvents::PRE_SUBMIT, array($this, 'onPreSubmit'));
    }
	/*private function addElements(FormInterface $form) {
		$repoCodecollection = $this->em->getRepository('AppBundle:Codecollection');
			
		$codescollection = $repoCodecollection->createQueryBuilder("q")
								->where('q.zoneutilisation LIKE :pattern')
								->setParameter('pattern', $pattern)
								->getQuery()
								->getResult();
		$form->add('codecollection', EntityType::class, array(
			'required' => true,
			'placeholder' => 'Select a collection ...',
			'class' => 'AppBundle:Codecollection',
			'choices' => $codescollection
		));
	}

		->add('codecollection', EntityType::class, array(
			'class'         => 'AppBundle:Codecollection',
			'choice_label'  => 'codecollection',
			'multiple'      => false,
			'query_builder' => function( codecollectionRepository $repository) use($pattern) {
								return $repository->getLikeQueryBuilder($pattern);
			//'query_builder' => function(EntityRepository $repository) use($pattern) {
							// return $repository->createQueryBuilder('u')    ->orderBy('u.fieldnum', 'ASC');
								}
			))
    
	function onPreSubmit(FormEvent $event) {
		$form = $event->getForm();
		$this->addElements($form);
	}*/
	/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver){
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Dsample' 
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix(){
        return 'appbundle_dsample';
    }
}