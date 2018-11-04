<?php
declare(strict_types=1);

namespace App\Entity\Traits\Article;

use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait NonRequired
 *
 * @package App\Entity\Traits
 * @author Alexander Saveliev <alex@spbcrew.com>
 */
trait NonRequired
{
    /**
     * @var string
     * @ORM\Column(name="article", type="string", length=255, nullable=true, unique=false)
     * @Assert\NotBlank(
     *      message = "Article should not be blank."
     * )
     */
    private $article;

    /**
     * Set article
     *
     * @param string|null $article
     * @return self
     */
    public function setArticle(?string $article = null): self
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
