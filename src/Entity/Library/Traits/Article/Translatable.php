<?php
declare(strict_types=1);

namespace App\Entity\Library\Traits\Article;

use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM;

use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Trait Translatable
 *
 * @package App\Entity\Library\Traits
 * @author Alexander Saveliev <alex@spbcrew.com>
 */
trait Translatable
{
    /**
     * @var string
     * @Gedmo\Translatable
     * @ORM\Column(name="article", type="string", length=255, nullable=false, unique=true)
     * @Assert\NotBlank(
     *      message = "Article should not be blank."
     * )
     * @Assert\Length(
     *      max = 255,
     *      maxMessage = "Article should be no longer than {{ limit }} characters."
     * )
     */
    private $article;

    /**
     * Set article
     *
     * @param string $article
     * @return self
     */
    public function setArticle(string $article): self
    {
        $this->article = $article;

        return $this;
    }

    /**
     * Get article
     *
     * @return string|null
     */
    public function getArticle(): ?string
    {
        return $this->article;
    }
}
