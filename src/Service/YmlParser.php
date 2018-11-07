<?php
declare(strict_types=1);

namespace App\Service;

use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Yaml\Exception\ParseException;

/**
 * Class YmlParser
 *
 * @package App\Service
 * @author Alexander Saveliev <alex@spbcrew.com>
 */
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
