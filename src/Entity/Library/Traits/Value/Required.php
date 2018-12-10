<?php
declare(strict_types=1);

namespace App\Entity\Library\Traits\Value;

use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait Required
 *
 * @package App\Entity\Library\Traits\Value
 * @author Alexander Saveliev <alex@spbcrew.com>
 */
trait Required
{
    /**
     * @var string
     * @ORM\Column(name="value", type="string", length=255, nullable=false, unique=false)
     * @Assert\NotBlank(
     *      message = "Value should not be blank."
     * )
     * @Assert\Length(
     *      max = 255,
     *      maxMessage = "Value should be no longer than {{ limit }} characters."
     * )
     */
    private $value;

    /**
     * Set value
     *
     * @param string $value
     * @return self
     */
    public function setValue(string $value): self
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return string|null
     */
    public function getValue(): ?string
    {
        return $this->value;
    }
}
