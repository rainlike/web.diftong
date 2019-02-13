<?php
/**
 * Menu Service
 * Provides functionality for building menu
 *
 * @package App\Service
 * @version 1.0.0
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @copyright 2018 diftong.com (https://www.diftong.com)
 * @author Alexander Saveliev <me@rainlike.com>
 */
declare(strict_types=1);

namespace App\Service;

use Doctrine\ORM\NonUniqueResultException;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

use Symfony\Contracts\Translation\TranslatorInterface as Translator;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface as Router;

use App\Service\YmlParser as Parser;
use App\Service\Settings as SettingSrv;

/** Class Menu */
class Menu
{
    /** @var RequestStack */
    private $request_stack;

    /** @var Router */
    private $router;

    /** @var Translator */
    private $translator;

    /** @var Parser */
    private $parser;

    /** @var SettingSrv */
    private $setting_srv;

    /** @var string */
    private $config_dir;

    /**
     * Name of file with configs
     * @var string
     */
    public const CONFIGS_FILE = 'menu.yml';

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
     * Content of configuration file
     * @var array
     */
    private $content;

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
     * @param Router $router
     * @param Translator $translator
     * @param Parser $parser
     * @param SettingSrv $settingSrv
     * @param string $configDir
     */
    public function __construct(
        RequestStack $requestStack,
        Router $router,
        Translator $translator,
        Parser $parser,
        SettingSrv $settingSrv,
        string $configDir
    ) {
        $this->request_stack = $requestStack;
        $this->router = $router;
        $this->translator = $translator;
        $this->parser = $parser;
        $this->setting_srv = $settingSrv;

        $this->config_dir = $configDir;

        $this->setContent();
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
     * @throws NonUniqueResultException
     */
    public function getMenu(): array
    {
        $menu = [];

        $menu['items'] = $this->generateItems();

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
     * Generate items for menu
     *
     * @return array
     * @throws NonUniqueResultException
     */
    private function generateItems(): array
    {
        $items = [];

        foreach ($this->content as $itemConfig) {
            $availableToUse = true;
            $hasSetting = $itemConfig['setting'] && $itemConfig['setting'] !== null;

            if ($hasSetting && $itemConfig['setting']['use']) {
                $availableToUse = $this->setting_srv->getSetting($itemConfig['setting']['name']);
            }

            if (!$hasSetting || $availableToUse) {
                $item = [];

                $item['name'] = $this->translator->trans(
                    $itemConfig['name']['key'],
                    [],
                    $itemConfig['name']['domain'] ?? self::TRANSLATION_DOMAIN,
                    $this->locale
                );
                $item['link'] = $this->router->generate(
                    $itemConfig['route']['name'],
                    $itemConfig['route']['params']
                );

                $items[] = $item;
            }
        }

        return $items;
    }

    /**
     * Set content from configuration file to the local storage
     *
     * @return void
     */
    private function setContent(): void
    {
        $filePath = $this->config_dir.'/app/'.self::CONFIGS_FILE;
        $fileContent = $this->parser->parse(\file_get_contents($filePath));

        $this->content = $fileContent;
    }
}
