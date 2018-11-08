<?php
declare(strict_types=1);

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM;

use App\Entity\Library\Traits\Id as IdField;
use App\Entity\Library\Traits\Enabled as EnabledField;

/**
 * Class Language
 *
 * @package App\Entity
 * @author Alexander Saveliev <alex@spbcrew.com>
 * @ORM\Table(name="app_language")
 * @ORM\Entity(repositoryClass="App\Repository\LanguageRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Language
{
    use IdField;
    use EnabledField;

    /**
     * @var string
     * @ORM\Column(name="locale", type="string", length=3, nullable=false, unique=true)
     * @Assert\NotBlank(
     *      message = "Locale should not be blank."
     * )
     * @Assert\Length(
     *      min = 2,
     *      max = 3,
     *      minMessage = "Locale must be at least {{ limit }} characters long.",
     *      maxMessage = "Locale must be no longer than {{ limit }} characters."
     * )
     */
    private $locale;

    /**
     * @var string
     * @ORM\Column(name="icu", type="string", length=7, nullable=false, unique=true)
     * @Assert\NotBlank(
     *      message = "ICU should not be blank."
     * )
     * @Assert\Length(
     *      min = 5,
     *      max = 7,
     *      minMessage = "ICU must be at least {{ limit }} characters long.",
     *      maxMessage = "ICU must be no longer than {{ limit }} characters."
     * )
     */
    private $icu;

    /**
     * @var string
     * @ORM\Column(name="name", type="string", length=50, nullable=false, unique=false)
     * @Assert\NotBlank(
     *      message = "Name should not be blank."
     * )
     * @Assert\Length(
     *      min = 5,
     *      max = 50,
     *      minMessage = "Name must be at least {{ limit }} characters long.",
     *      maxMessage = "Name must be no longer than {{ limit }} characters."
     * )
     */
    private $name;

    /** @return string */
    public function __toString(): string
    {
        return (string)$this->getId();
    }

    /**
     * Set locale
     *
     * @param string $locale
     * @return self
     */
    public function setLocale(string $locale): self
    {
        $this->locale = $locale;

        return $this;
    }

    /**
     * Get locale
     *
     * @return string|null
     */
    public function getLocale(): ?string
    {
        return $this->locale;
    }

    /**
     * Set icu
     *
     * @param string $icu
     * @return self
     */
    public function setIcu(string $icu): self
    {
        $this->icu = $icu;

        return $this;
    }

    /**
     * Get icu
     *
     * @return string|null
     */
    public function getIcu(): ?string
    {
        return $this->icu;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return self
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }
}
