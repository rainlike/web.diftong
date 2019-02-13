<?php
/**
 * Wrapper Trait
 * Trait for stylizing console output
 *
 * @package App\Command\Library\Traits
 * @version 1.0.0
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @copyright 2018 diftong.com (https://www.diftong.com)
 * @author Alexander Saveliev <me@rainlike.com>
 */
declare(strict_types=1);

namespace App\Command\Library\Traits;

use Symfony\Component\Console\Output\OutputInterface;

/** Trait WrapperTrait */
trait WrapperTrait
{
    /** @var string */
    public static $INFO = 'info';

    /** @var string */
    public static $COMMENT = 'comment';

    /** @var string */
    public static $QUESTION = 'question';

    /** @var string */
    public static $ERROR = 'error';

    /**
     * Types of wrapper
     * @var array
     */
    public static $types = [
        'info',
        'comment',
        'question',
        'error'
    ];

    /** @var string */
    public static $delimiter = '=========================';

    /** @var string */
    public static $break = "\n";

    /**
     * Wrap string into tags
     *
     * @param string $line
     * @param string $type
     * @return string
     */
    protected function wrapIn(string $line, string $type): string
    {
        $type = \in_array($type, self::$types) ? $type : self::$INFO;

        return '<'.$type.'>'.$line.'</'.$type.'>';
    }

    /**
     * Wrap string in info tags
     *
     * @param string $line
     * @return string
     */
    protected function wrapInInfo(string $line): string
    {
        return '<'.self::$INFO.'>'.$line.'</'.self::$INFO.'>';
    }

    /**
     * Wrap string in comment tags
     *
     * @param string $line
     * @return string
     */
    protected function wrapInComment(string $line): string
    {
        return '<'.self::$COMMENT.'>'.$line.'</'.self::$COMMENT.'>';
    }

    /**
     * Wrap string in question tags
     *
     * @param string $line
     * @return string
     */
    protected function wrapInQuestion(string $line): string
    {
        return '<'.self::$QUESTION.'>'.$line.'</'.self::$QUESTION.'>';
    }

    /**
     * Wrap string in error tags
     *
     * @param string $line
     * @return string
     */
    protected function wrapInError(string $line): string
    {
        return '<'.self::$ERROR.'>'.$line.'</'.self::$ERROR.'>';
    }

    /**
     * Write line into console output
     *
     * @param string $line
     * @param string $type
     * @param OutputInterface $output
     * @return void
     */
    protected function write(string $line, string $type, OutputInterface $output): void
    {
        $type = \in_array($type, self::$types) ? $type : self::$INFO;

        $output->writeln($this->wrapIn($line, $type));
    }

    /**
     * Write info line into console output
     *
     * @param string $line
     * @param OutputInterface $output
     * @return void
     */
    protected function writeInfo(string $line, OutputInterface $output): void
    {
        $output->writeln($this->wrapInInfo($line));
    }

    /**
     * Write comment line into console output
     *
     * @param string $line
     * @param OutputInterface $output
     * @return void
     */
    protected function writeComment(string $line, OutputInterface $output): void
    {
        $output->writeln($this->wrapInComment($line));
    }

    /**
     * Write question line into console output
     *
     * @param string $line
     * @param OutputInterface $output
     * @return void
     */
    protected function writeQuestion(string $line, OutputInterface $output): void
    {
        $output->writeln($this->wrapInQuestion($line));
    }

    /**
     * Write error line into console output
     *
     * @param string $line
     * @param OutputInterface $output
     * @return void
     */
    protected function writeError(string $line, OutputInterface $output): void
    {
        $output->writeln($this->wrapInError($line));
    }

    /**
     * Write line delimiter
     *
     * @param OutputInterface $output
     * @return void
     */
    protected function writeDelimiter(OutputInterface $output): void
    {
        $output->writeln(self::$delimiter);
    }

    /**
     * Write break line
     *
     * @param OutputInterface $output
     * @return void
     */
    protected function writeBreak(OutputInterface $output): void
    {
        $output->writeln(self::$break);
    }
}
