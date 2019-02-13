<?php
declare(strict_types=1);

namespace App\Entity\Library\Traits\Article;

use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait NonRequired
 *
 * @package App\Entity\Library\Traits\Article
 * @author Alexander Saveliev <me@rainlike.com>
 */
trait NonRequired
{
    /**
     * @var string
     * @ORM\Column(name="article", type="string", length=255, nullable=true, unique=false)
     * @Assert\Length(
     *      max = 255,
     *      maxMessage = "Article should be no longer than {{ limit }} characters."
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
