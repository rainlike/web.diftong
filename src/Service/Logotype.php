<?php
/**
 * Logotype Service
 * Provides few variants of site logo
 *
 * @package App\Service
 * @version 1.0.0
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @copyright 2018 spbcrew.com (https://www.spbcrew.com)
 * @author Alexander Saveliev <alex@spbcrew.com>
 */
declare(strict_types=1);

namespace App\Service;

use App\Utility\StaticStorage;

/** Class Logotype */
class Logotype
{
    /** @var Seo */
    private $seo;

    /** @var string */
    private $public_dir;

    /** @var string */
    private $site_name;

    /**
     * Type of logo
     * @var string
     */
    private $type;

    /**
     * Path to logo file
     * @var string
     */
    public const LOGO_PATH = 'cdn/logo.svg';

    /**
     * Default type of logo
     * @var string
     */
    public const DEFAULT_TYPE = 'image';

    /**
     * Possible types of logo
     * @var array
     */
    public const POSSIBLE_TYPES = [
        self::TYPE_PHRASE,
        self::TYPE_IMAGE,
        self::TYPE_LINK
    ];

    /**
     * Constants of possible types of logo
     * @var string
     */
    public const TYPE_PHRASE = 'phrase';
    public const TYPE_IMAGE = 'image';
    public const TYPE_LINK = 'link';

    /**
     * Verbose mod
     * @var bool
     */
    private $verbose_mod;

    /**
     * Logotype constructor
     *
     * @param Seo $seo
     * @param string $publicDir
     * @param string $siteName
     */
    public function __construct(
        Seo $seo,
        string $publicDir,
        string $siteName
    ) {
        $this->seo = $seo;

        $this->public_dir = $publicDir;
        $this->site_name = $siteName;
        $this->type = self::DEFAULT_TYPE;

        $this->verbose_mod = false;
    }

    /**
     * Set type of logo
     *
     * @param string $type
     * @return self
     */
    public function setType(string $type): self
    {
        $this->type = \in_array($type, self::POSSIBLE_TYPES)
            ? $type
            : self::DEFAULT_TYPE;

        return $this;
    }

    /**
     * Get logo type
     *
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Set verbose mod
     *
     * @param bool $verboseMod
     * @return self
     */
    public function setVerboseMod(bool $verboseMod = true): self
    {
        $this->verbose_mod = $verboseMod;

        return $this;
    }

    /**
     * Get logo
     *
     * @param null|string $type
     * @param bool $verbose
     * @return string|array
     */
    public function getLogo(?string $type = null, bool $verbose = false)
    {
        if ($verbose) {
            return $this->getVerboseLogo($type);
        }

        $type = $this->validateType($type);

        $caller = 'get'.\ucfirst($type).'Logo';
        return $this->$caller();
    }

    /**
     * Get logo with verbose mod
     *
     * @param null|string $type
     * @return array
     */
    public function getVerboseLogo(?string $type = null): array
    {
        $type = $this->validateType($type);

        $caller = 'get'.\ucfirst($type).'Logo';

        $verboseLogo = [
            'data' => $this->$caller(),
            'type' => $this->type,
            'alt' => $this->seo->getLogoText(),
            'title' => $this->seo->getLogoText()
        ];

        return $verboseLogo;
    }

    /**
     * Get sketch
     *
     * @return array
     */
    public function getSketch(): array
    {
        return [
            'dif',
            'tong',
            '.com'
        ];
    }

    /**
     * Get logo as phrase
     * called in getLogo() method
     *
     * @return string
     */
    private function getPhraseLogo(): string
    {
        return $this->site_name;
    }

    /**
     * Get path to image of logo
     * called in getLogo() method
     *
     * @return string
     */
    private function getImageLogo(): string
    {
        $fileExists = \file_exists($this->public_dir.'/'.self::LOGO_PATH);
        if (!$fileExists) {
            $this->type = self::LINK_TYPE;

            return StaticStorage::logoLink();
        }

        return self::LOGO_PATH;
    }

    /**
     * Get outside link to logo
     * called in getLogo() method
     *
     * @return string
     */
    private function getLinkLogo(): string
    {
        return StaticStorage::logoLink();
    }

    /**
     * Check & return valid type of logo
     *
     * @param null|string $type
     * @return string
     */
    private function validateType(?string $type = null): string
    {
        return ($type && \in_array($type, self::POSSIBLE_TYPES))
            ? $type
            : $this->type;
    }
}
