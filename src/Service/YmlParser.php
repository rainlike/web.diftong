<?php
/**
 * Yaml Parser Proxy Service
 * It represents a wrapper around basic Symfony Yaml parser
 *
 * @package App\Service
 * @version 1.0.0
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @copyright 2018 spbcrew.com (https://www.spbcrew.com)
 * @author Alexander Saveliev <alex@spbcrew.com>
 */
declare(strict_types=1);

namespace App\Service;

use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Yaml\Exception\ParseException;

/** Class YmlParser */
class YmlParser
{
    /**
     * Parse Yaml file
     *
     * @param string $input - string containing YAML
     * @param int $flags - a bit field of PARSE_* constants to customize the YAML parser behavior
     * @return mixed - the YAML converted to a PHP value
     * @throws ParseException
     */
    public function parse(string $input, int $flags = 0)
    {
        return Yaml::parse($input, $flags);
    }
}
