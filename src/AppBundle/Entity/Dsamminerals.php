<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Dsamminerals
 *
 * @ORM\Table(name="dsamminerals", uniqueConstraints={@ORM\UniqueConstraint(name="dsamminerals_unique", columns={"idcollection", "idsample", "idmineral"})}, indexes={@ORM\Index(name="IDX_1AC34B3131E4780895B6DB6F", columns={"idcollection", "idsample"}), @ORM\Index(name="IDX_1AC34B31C29FFB11", columns={"idmineral"})})
 * @ORM\Entity
 */
class Dsamminerals
{
    /**
     * @var integer
     *
     * @ORM\Column(name="pk", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="dsamminerals_pk_seq", allocationSize=1, initialValue=1)
     */
    private $pk;

    /**
     * @var integer
     *
     * @ORM\Column(name="grade", type="smallint", nullable=true)
     */
    private $grade = '0';

    /**
     * @var \AppBundle\Entity\Dsample
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Dsample")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idcollection", referencedColumnName="idcollection"),
     *   @ORM\JoinColumn(name="idsample", referencedColumnName="idsample")
     * })
     */
    private $idcollection;

    /**
     * @var \AppBundle\Entity\Lminerals
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Lminerals")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idmineral", referencedColumnName="idmineral")
     * })
     */
    private $idmineral;



    /**
     * Get pk
     *
     * @return integer
     */
    public function getPk()
    {
        return $this->pk;
    }

    /**
     * Set grade
     *
     * @param integer $grade
     *
     * @return Dsamminerals
     */
    public function setGrade($grade)
    {
        $this->grade = $grade;

        return $this;
    }

    /**
     * Get grade
     *
     * @return integer
     */
    public function getGrade()
    {
        return $this->grade;
    }

    /**
     * Set idcollection
     *
     * @param \AppBundle\Entity\Dsample $idcollection
     *
     * @return Dsamminerals
     */
    public function setIdcollection(\AppBundle\Entity\Dsample $idcollection = null)
    {
        $this->idcollection = $idcollection;

        return $this;
    }

    /**
     * Get idcollection
     *
     * @return \AppBundle\Entity\Dsample
     */
    public function getIdcollection()
    {
        return $this->idcollection;
    }

    /**
     * Set idmineral
     *
     * @param \AppBundle\Entity\Lminerals $idmineral
     *
     * @return Dsamminerals
     */
    public function setIdmineral(\AppBundle\Entity\Lminerals $idmineral = null)
    {
        $this->idmineral = $idmineral;

        return $this;
    }

    /**
     * Get idmineral
     *
     * @return \AppBundle\Entity\Lminerals
     */
    public function getIdmineral()
    {
        return $this->idmineral;
    }
}
