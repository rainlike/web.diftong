<?php
/**
 * Logger Service
 * Service for logging custom records
 *
 * @package App\Service
 * @version 1.0.0
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @copyright 2018 spbcrew.com (https://www.spbcrew.com)
 * @author Alexander Saveliev <alex@spbcrew.com>
 */
declare(strict_types=1);

namespace App\Service;

/** Class Logger */
class Logger
{
    /** @var string */
    private $file;

    /** @var string */
    private $file_path;

    /** @var string */
    private $file_name;

    /**
     * Default name of log file
     * @var string
     */
    private $default_file_name = 'app.log';

    /**
     * Default path to log file
     * @var string
     */
    private $default_file_path;

    /**
     * Column separator
     * @var string
     */
    private const COLUMN_SEPARATOR = ';';

    /**
     * Types of logs
     * @var array
     */
    public const TYPES = [
        self::TYPE_INFO,
        self::TYPE_SUCCESS,
        self::TYPE_WARNING,
        self::TYPE_ERROR
    ];

    /**
     * Constants of possible types of logs
     * @var string
     */
    public const TYPE_INFO = 'info';
    public const TYPE_SUCCESS = 'success';
    public const TYPE_WARNING = 'warning';
    public const TYPE_ERROR = 'error';

    /**
     * Fallback log type
     * @var string
     */
    private const TYPE_FALLBACK = 'obscure';

    /**
     * Logger constructor
     *
     * @param string $logsDirectory
     * @param string|null $fileName
     * @param string|null $filePath
     */
    public function __construct(string $logsDirectory, ?string $fileName = null, ?string $filePath = null)
    {
        $this->default_file_path = $logsDirectory;

        if ($fileName) {
            $this->setFileName($fileName);
        } else {
            $this->file_name = $this->default_file_name;
        }

        if ($filePath) {
            $this->setFilePath($filePath);
        } else {
            $this->file_path = $this->default_file_path;
        }

        $this->file = $this->file_path.'/'.$this->file_name;
    }

    /**
     * Set path to file
     *
     * @param string $filePath
     * @return self
     */
    public function setFilePath(string $filePath): self
    {
        $this->file_path = $filePath;

        $this->file = $this->file_path.'/'.($this->file_name ?? $this->default_file_name);

        return $this;
    }

    /**
     * set file name
     *
     * @param string $fileName
     * @return self
     */
    public function setFileName(string $fileName): self
    {
        $this->file_name = $fileName;

        $this->file = ($this->file_path ?? $this->default_file_path).'/'.$this->file_name;

        return $this;
    }

    /**
     * Write log message by parameters
     *
     * @param array $parameters
     * @param string $type
     * @return bool
     * @throws \InvalidArgumentException
     */
    public function log(array $parameters, string $type): bool
    {
        $message = $this->createLogMessage($parameters, $type);

        return (bool)@\file_put_contents($this->file, $message, FILE_APPEND);
    }

    /**
     * Write log message
     *
     * @param string $message
     * @param string|null $type
     * @return bool
     */
    public function logMessage(string $message, ?string $type = null): bool
    {
        $type = $type ?? self::TYPE_INFO;

        return (bool)@\file_put_contents(
            $this->file,
            \strtoupper($this->verifyType($type)).': '.$message,
            FILE_APPEND
        );
    }

    /**
     * Create log message
     *
     * @param array $parameters
     * @param string $type
     * @param string $dateFormat
     * @return string
     */
    private function createLogMessage(
        array $parameters,
        string $type,
        string $dateFormat = 'Y-m-d H:i:s'
    ): string
    {
        $logMessage = \strtoupper($this->verifyType($type));
        $logMessage .= ' DATE: '.\date($dateFormat).self::COLUMN_SEPARATOR.' ';

        foreach ($parameters as $parameter => $value) {
            $logMessage .= \strtoupper(\str_replace('_', ' ', $parameter)).': '.$value.self::COLUMN_SEPARATOR.' ';
        }

        $logMessage = \trim($logMessage)."\n";

        return $logMessage;
    }

    /**
     * Verify log type
     *
     * @param string $type
     * @return string
     */
    private function verifyType(string $type)
    {
        return \in_array($type, self::TYPES, false)
            ? $type
            : self::TYPE_FALLBACK;
    }
}
