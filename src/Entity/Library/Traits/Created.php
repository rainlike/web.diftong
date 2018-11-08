<?php
declare(strict_types=1);

namespace App\Entity\Library\Traits;

use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait Created
 *
 * @package App\Entity\Library\Traits
 * @author Alexander Saveliev <alex@spbcrew.com>
 */
trait Created
{
    /**
     * @var \DateTime
     * @ORM\Column(name="created", type="datetime", nullable=false, unique=false)
     * @Assert\NotBlank(
     *      message = "Created date should not be blank."
     * )
     * @Assert\DateTime(
     *      message = "Created date is not valid DateTime format."
     * )
     */
    private $created;

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return self
     */
    public function setCreated(\DateTime $created): self
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime|null
     */
    public function getCreated(): ?\DateTime
    {
        return $this->created;
    }
}
