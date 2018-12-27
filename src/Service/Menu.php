<?php
/**
 * Menu Service
 * Provides functionality for building menu
 *
 * @package App\Service
 * @version 1.0.0
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @copyright 2018 spbcrew.com (https://www.spbcrew.com)
 * @author Alexander Saveliev <alex@spbcrew.com>
 */
declare(strict_types=1);

namespace App\Service;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

use Symfony\Component\Translation\TranslatorInterface as Translator;

/** Class Menu */
class Menu
{
    /** @var RequestStack */
    private $request_stack;

    /** @var Translator */
    private $translator;

    /**
     * Domain for translations
     * @var string
     */
    private const TRANSLATION_DOMAIN = 'menu';

    /** @var Request */
    private $request;

    /** @var string */
    private $locale;

        /**
     * Available mods for Menu
     * @var bool
     */
    private $capitalize_mode = true;
    private $back_link_mod = true;

    /**
     * Menu constructor
     *
     * @param RequestStack $requestStack
     * @param Translator $translator
     */
    public function __construct(
        RequestStack $requestStack,
        Translator $translator
    ) {
        $this->request_stack = $requestStack;
        $this->translator = $translator;
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
     * Set capitalize mod
     *
     * @param bool $mode
     * @return self
     */
    public function setCapitalizeMode(bool $mode = true): self
    {
        $this->capitalize_mode = $mode;

        return $this;
    }

    /**
     * Set back-link mod
     *
     * @param bool $mode
     * @return self
     */
    public function setBackLinkMod(bool $mode = true): self
    {
        $this->back_link_mod = $mode;

        return $this;
    }

    /**
     * Initialization of menu
     *
     * @param Request $request
     * @return self
     */
    public function init(Request $request): self
    {
        $this->request = $request;
        $this->locale = $this->request->getLocale();

        return $this;
    }

    /**
     * Generate menu
     *
     * @return array
     */
    public function getMenu(): array
    {
        $menu = [];

        $menu['items'] = $this->mock();

        if ($this->back_link_mod) {
            $menu['back_link'] = $this->getBackLink();
        }

        return $menu;
    }

    /**
     * Get previous link
     *
     * @return string|null
     */
    public function getBackLink(): ?string
    {
        return $this->request->headers->get('referer');
    }

    /**
     * @TODO: mock
     * @return array
     */
    private function mock(): array
    {
        return [
            [
                'name' => $this->translator->trans(
                    'items.grammar',
                    [],
                    self::TRANSLATION_DOMAIN,
                    $this->locale
                ),
                'link' => '#'
            ],
            [
                'name' => $this->translator->trans(
                    'items.phonetics',
                    [],
                    self::TRANSLATION_DOMAIN,
                    $this->locale
                ),
                'link' => '#'
            ],
            [
                'name' => $this->translator->trans(
                    'items.lexis',
                    [],
                    self::TRANSLATION_DOMAIN,
                    $this->locale
                ),
                'link' => '#'
            ],
            [
                'name' => $this->translator->trans(
                    'items.articles',
                    [],
                    self::TRANSLATION_DOMAIN,
                    $this->locale
                ),
                'link' => '#'
            ],
            [
                'name' => $this->translator->trans(
                    'items.topics',
                    [],
                    self::TRANSLATION_DOMAIN,
                    $this->locale
                ),
                'link' => '#'
            ],
            [
                'name' => $this->translator->trans(
                    'items.lyrics',
                    [],
                    self::TRANSLATION_DOMAIN,
                    $this->locale
                ),
                'link' => '#'
            ]
        ];
    }
}
