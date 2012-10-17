<?php
namespace Application\Entity;

use ZfcUser\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation as ZF;

/**
 * @ORM\Entity
 */
class Settings
{
    /**
     * @var User
     * @ORM\Id
     * @ORM\OneToOne(targetEntity="ZfcUser\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="user_id")
     * @ZF\Exclude()
     */
    private $user;

    /**
     * @var string
     * @ORM\Column(type="string", length=1024, nullable=true)
     * @ZF\Filter({"name":"StringTrim"})
     * @ZF\Options({"label":"Defaut search string:"})
     * @ZF\Attributes({"placeholder":"Example: +1080p|720p -series", "class":"input-xxlarge"})
     */
    private $defaultSearchString;

    /**
     * @var int
     * @ORM\Column(type="integer", nullable=true)
     * @ZF\Options({"label":"Minimal size (mb):"})
     * @ZF\Attributes({"placeholder":"Example: 1024"})
     * @ZF\Type("Zend\Form\Element\Number")
     */
    private $defaultMinSize;

    /**
     * @var int
     * @ORM\Column(type="integer", nullable=true)
     * @ZF\Options({"label":"Maximal size (mb):"})
     * @ZF\Attributes({"placeholder":"Example: 51200"})
     * @ZF\Type("Zend\Form\Element\Number")
     */
    private $defaultMaxSize;

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
    public function getDefaultSearchString()
    {
        return $this->defaultSearchString;
    }

    /**
     * @param string $defaultSearchString
     */
    public function setDefaultSearchString($defaultSearchString)
    {
        $this->defaultSearchString = (string) $defaultSearchString;
    }

    /**
     * @return int
     */
    public function getDefaultMinSize()
    {
        return $this->defaultMinSize;
    }

    /**
     * @param int $defaultMinSize
     */
    public function setDefaultMinSize($defaultMinSize)
    {
        $this->defaultMinSize = $defaultMinSize == null ? null : (int) $defaultMinSize;
    }

    /**
     * @return int
     */
    public function getDefaultMaxSize()
    {
        return $this->defaultMaxSize;
    }

    /**
     * @param int $defaultMaxSize
     */
    public function setDefaultMaxSize($defaultMaxSize)
    {
        $this->defaultMaxSize = $defaultMaxSize == null ? null : (int) $defaultMaxSize;
    }

    /**
     * Fetches search string addition for torrentz
     *
     * @return string
     */
    public function getSearchAddition()
    {
        $string = $this->getDefaultSearchString();
        if($this->getDefaultMinSize() && $this->getDefaultMaxSize())
        {
            $string .= ' size ' . $this->getDefaultMinSize() . 'm - ' . $this->getDefaultMaxSize() . 'm';
        }
        else if($this->getDefaultMinSize())
        {
            $string .= ' size > ' . $this->getDefaultMinSize() . 'm';
        }
        else if($this->getDefaultMaxSize())
        {
            $string .= ' size < ' . $this->getDefaultMaxSize() . 'm';
        }

        return $string;
    }
}