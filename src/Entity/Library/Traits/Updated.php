<?php
declare(strict_types=1);

namespace App\Entity\Library\Traits;

use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM;

use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Trait Updated
 *
 * @package App\Entity\Library\Traits
 * @author Alexander Saveliev <alex@spbcrew.com>
 */
trait Updated
{
    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="updated", type="datetime", nullable=true, unique=false)
     * @Assert\DateTime(
     *      message="Updated date is not valid DateTime format."
     * )
     */
    private $updated;

    /**
     * Set updated
     *
     * @param \DateTime|null $updated
     * @return self
     */
    public function setUpdated(?\DateTime $updated = null): self
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime|null
     */
    public function getUpdated(): ?\DateTime
    {
        return $this->updated;
    }
}
