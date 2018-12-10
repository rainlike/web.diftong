<?php
/**
 * Style Trait
 * Trait for proxy of SymfonyStyle console component
 *
 * @package App\Service
 * @version 1.0.0
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @copyright 2018 spbcrew.com (https://www.spbcrew.com)
 * @author Alexander Saveliev <alex@spbcrew.com>
 */
declare(strict_types=1);

namespace App\Command\Traits;

use Symfony\Component\Console\Style\SymfonyStyle;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/** Trait StyleTrait */
trait StyleTrait
{
    /**
     * Get new instance of SymfonyStyle component
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return SymfonyStyle
     */
    protected function getIo(InputInterface $input, OutputInterface $output): SymfonyStyle
    {
        return new SymfonyStyle($input, $output);
    }
}
