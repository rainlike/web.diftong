<?php
/**
 * Socials Service
 * Provides functionality for getting information about social accounts
 *
 * @package App\Service
 * @version 1.0.0
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @copyright 2018 spbcrew.com (https://www.spbcrew.com)
 * @author Alexander Saveliev <alex@spbcrew.com>
 */
declare(strict_types=1);

namespace App\Service;

use App\Service\YmlParser as Parser;

/** Class Socials */
class Socials
{
    /** @var Parser */
    private $parser;

    /** @var string */
    private $config_dir;

    /**
     * Name of file with list of social accounts
     * @var string
     */
    public const CONFIGS_FILE = 'socials.yml';

    /**
     * Socials constructor
     *
     * @param Parser $parser
     * @param string $configDir
     */
    public function __construct(
        Parser $parser,
        string $configDir
    ) {
        $this->parser = $parser;
        $this->config_dir = $configDir;
    }

    /**
     * Get social accounts for footer
     *
     * @return array|null
     */
    public function getFooterItems(): ?array {
        $filePath = $this->config_dir.'/app/'.self::CONFIGS_FILE;
        $fileContent = $this->parser->parse(\file_get_contents($filePath));

        return $fileContent ?? null;
    }
}
