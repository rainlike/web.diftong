<?php
declare(strict_types=1);

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM;

use Gedmo\Mapping\Annotation as Gedmo;

use App\Entity\Library\BasicEntity;

use App\Entity\Library\Interfaces\IBasic;
use App\Entity\Library\Interfaces\ISeoable;
use App\Entity\Library\Interfaces\ILastable;

use App\Entity\Library\Traits\Uri\Unique as UriField;
use App\Entity\Library\Traits\Content\Required as ContentField;
use App\Entity\Library\Traits\Title\RequiredUnique as TitleField;
use App\Entity\Library\Traits\Description\NonRequired as DescriptionField;

/**
 * Class Article
 * Contains articles
 *
 * @package App\Entity
 * @version 1.0.0
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @copyright 2018 spbcrew.com (https://www.spbcrew.com)
 * @author Alexander Saveliev <alex@spbcrew.com>
 * @ORM\Table(name="app_article")
 * @ORM\Entity(repositoryClass="App\Repository\ArticleRepository")
 */
class Article extends BasicEntity implements IBasic, ISeoable, ILastable
{
    use TitleField;
    use UriField;
    use ContentField;
    use DescriptionField;

    /**
     * @var string
     * @ORM\Column(name="formatted_content", type="text", length=5000, nullable=false, unique=false)
     * @Assert\NotBlank(
     *      message="Formatted content should not be blank."
     * )
     * @Assert\Length(
     *      max = 5000,
     *      maxMessage = "Formatted content should be no longer than {{ limit }} characters."
     * )
     */
    private $formattedContent;

    /**
     * @var Language
     * @ORM\ManyToOne(targetEntity="Language", inversedBy="articles")
     * @ORM\JoinColumn(name="language", referencedColumnName="id", nullable=false, unique=false)
     * @Assert\NotBlank(
     *      message = "Language should not be blank."
     * )
     */
    private $language;

    /**
     * @var Portal
     * @ORM\ManyToOne(targetEntity="Portal", inversedBy="articles")
     * @ORM\JoinColumn(name="portal", referencedColumnName="id", nullable=false, unique=false)
     * @Assert\NotBlank(
     *      message = "Portal should not be blank."
     * )
     */
    private $portal;

    /** @return string */
    public function __toString(): string
    {
        return (string)$this->getId();
    }

    /**
     * Set formattedContent
     *
     * @param string $formattedContent
     * @return self
     */
    public function setFormattedContent(string $formattedContent): self
    {
        $this->formattedContent = $formattedContent;

        return $this;
    }

    /**
     * Get formattedContent
     *
     * @return string|null
     */
    public function getFormattedContent(): ?string
    {
        return $this->formattedContent;
    }

    /**
     * Set language
     *
     * @param Language $language
     * @return self
     */
    public function setLanguage(Language $language): self
    {
        $this->language = $language;
        $language->addArticle($this);

        return $this;
    }

    /**
     * Get language
     *
     * @return Language|null
     */
    public function getLanguage(): ?Language
    {
        return $this->language;
    }

    /**
     * Set portal
     *
     * @param Portal $portal
     * @return self
     */
    public function setPortal(Portal $portal): self
    {
        $this->portal = $portal;
        $portal->addArticle($this);

        return $this;
    }

    /**
     * Get portal
     *
     * @return Portal|null
     */
    public function getPortal(): ?Portal
    {
        return $this->portal;
    }
}
