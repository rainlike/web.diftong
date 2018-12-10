<?php
/**
 * Table Trait
 * Trait for proxy of Table console component
 *
 * @package App\Service
 * @version 1.0.0
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @copyright 2018 spbcrew.com (https://www.spbcrew.com)
 * @author Alexander Saveliev <alex@spbcrew.com>
 */
declare(strict_types=1);

namespace App\Command\Traits;

use Symfony\Component\Console\Helper\Table;

use Symfony\Component\Console\Output\OutputInterface;

/** Trait TableTrait */
trait TableTrait
{
    /**
     * Get new instance of Table component
     *
     * @param OutputInterface $output
     * @param null|string $style
     * @return Table
     */
    protected function getTable(OutputInterface $output, ?string $style = null): Table
    {
        $table = new Table($output);

        if ($style) {
            $style = \in_array($style, $this->getTableStyleList())
                ? $style
                : $this->getDefaultTableStyle();
            $table->setStyle($style);
        }

        return $table;
    }

    /**
     * Get list of possible styles for table
     *
     * @return array
     */
    protected function getTableStyleList(): array
    {
        return [
            'borderless',
            'box',
            'box-double'
        ];
    }

    /**
     * Get default style for table borders
     *
     * @return string
     */
    protected function getDefaultTableStyle(): string
    {
        return 'borderless';
    }
}
