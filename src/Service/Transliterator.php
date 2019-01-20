<?php
/**
 * Library
 * Provides proxy for default Transliterator class
 *
 * @package App\Service
 * @version 1.0.0
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @copyright 2018 spbcrew.com (https://www.spbcrew.com)
 * @author Alexander Saveliev <alex@spbcrew.com>
 */
declare(strict_types=1);

namespace App\Service;

/** Class Transliterator */
class Transliterator
{
    /** @var \Transliterator */
    private $transliterator;

    /** @var \Transliterator */
    private $transliterator_ascii;

    /**
     * Transliterator constructor
     *
     * @param string $layout
     * @param string $asciiLayout
     */
    public function __construct(
        string $layout = 'Any-Latin',
        string $asciiLayout = 'Latin-ASCII'
    ) {
        $this->transliterator = \Transliterator::create($layout);
        $this->transliterator_ascii = \Transliterator::create($asciiLayout);
    }

    /**
     * Transliterator destructor
     */
    public function __destruct()
    {
        $this->transliterator = null;
        $this->transliterator_ascii = null;
    }

    /**
     * Set encoding fot Transliterator
     *
     * @param string $layout
     * @return self
     */
    public function setTransliteratorLayout(string $layout): self
    {
        $this->transliterator = \Transliterator::create($layout);

        return $this;
    }

    /**
     * Set encoding fot Transliterator ASCII
     *
     * @param string $layout
     * @return self
     */
    public function setTransliteratorAsciiLayout(string $layout): self
    {
        $this->transliterator_ascii = \Transliterator::create($layout);

        return $this;
    }

    /**
     * Transliterate string
     *
     * @param string $subject
     * @return string
     */
    public function transliterate(string $subject): string
    {
        return $this->transliterator_ascii->transliterate($this->transliterator->transliterate($subject));
    }
}
