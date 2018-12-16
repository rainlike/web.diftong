<?php
declare(strict_types=1);

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM;

use App\Entity\Library\BasicEntity;

use App\Entity\Library\Interfaces\IBasic;

/**
 * Class Quote
 *
 * @package App\Entity
 * @author Alexander Saveliev <alex@spbcrew.com>
 * @ORM\Table(name="app_quote")
 * @ORM\Entity(repositoryClass="App\Repository\QuoteRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Quote extends BasicEntity implements IBasic
{
    /**
     * @var string
     * @ORM\Column(name="text", type="text", length=1000, nullable=false, unique=false)
     * @Assert\NotBlank(
     *      message="Text should not be blank."
     * )
     * @Assert\Length(
     *      max = 1000,
     *      maxMessage = "Text should be no longer than {{ limit }} characters."
     * )
     */
    private $text;

    /**
     * @var string
     * @ORM\Column(name="author", type="string", length=255, nullable=false, unique=false)
     * @Assert\NotBlank(
     *      message = "Author should not be blank."
     * )
     * @Assert\Length(
     *      max = 255,
     *      maxMessage = "Author should be no longer than {{ limit }} characters."
     * )
     */
    private $author;

    /** @return string */
    public function __toString(): string
    {
        return (string)$this->getId();
    }

    /**
     * Set text
     *
     * @param string $text
     * @return self
     */
    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string|null
     */
    public function getText(): ?string
    {
        return $this->text;
    }

    /**
     * Set author
     *
     * @param string $author
     * @return self
     */
    public function setAuthor(string $author): self
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return string|null
     */
    public function getAuthor(): ?string
    {
        return $this->author;
    }
}
