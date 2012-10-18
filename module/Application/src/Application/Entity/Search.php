<?php
namespace Application\Entity;

use ZfcUser\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation as ZF;

/**
 * @ORM\Entity
 */
class Search
{
    /**
     * @var integer
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     * @ZF\Exclude()
     */
    private $id;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="ZfcUser\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="user_id")
     * @ZF\Exclude()
     */
    private $user;

    /**
     * @var string
     * @ORM\Column(type="string", length=1024, nullable=false)
     * @ZF\Filter({"name":"StringTrim"})
     * @ZF\Options({"label":"Search string:"})
     * @ZF\Validator({"name":"StringLength", "options":{"min":1, "max":1024}})
     * @ZF\Attributes({"placeholder":"Example: the dark knight rises", "class":"input-xxlarge"})
     */
    private $query;

    /**
     * @var int
     * @ZF\Exclude()
     */
    private $result = '-';

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return \ZfcUser\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param \ZfcUser\Entity\User $user
     */
    public function setUser(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return string
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * @param string $query
     */
    public function setQuery($query)
    {
        $this->query = (string) $query;
    }

    /**
     * @return int
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @param int $result
     */
    public function setResult($result)
    {
        $this->result = $result;
    }
}