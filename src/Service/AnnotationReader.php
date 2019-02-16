<?php
/**
 * AnnotationReader Service
 * A proxy service for reading annotations
 *
 * @package App\Service
 * @version 1.0.0
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @copyright 2018 diftong.com (https://www.diftong.com)
 * @author Alexander Saveliev <me@rainlike.com>
 */
declare(strict_types=1);

namespace App\Service;

use Doctrine\Common\Annotations\Reader;

/** Class AnnotationReader */
class AnnotationReader
{
    /** @var Reader */
    private $reader;

    /**
     * AnnotationReader constructor
     *
     * @param Reader $reader
     */
    public function __construct(Reader $reader) {
        $this->reader = $reader;
    }

    /**
     * Get all annotations of class
     *
     * @param string $class
     * @return array
     * @throws \ReflectionException
     */
    public function getClassAnnotations(string $class): array
    {
        return $this->reader->getClassAnnotations($this->getReflectionClass($class));
    }

    /**
     * Get class annotation
     *
     * @param string $class
     * @param string $name
     * @return object|null
     * @throws \ReflectionException
     */
    public function getClassAnnotation(string $class, string $name)
    {
        return $this->reader->getClassAnnotation(
            $this->getReflectionClass($class),
            $name
        );
    }

    /**
     * Get all annotations of method
     *
     * @param string $method
     * @param string $class
     * @return array
     * @throws \ReflectionException
     */
    public function getMethodAnnotations(string $method, string $class): array
    {
        return $this->reader->getMethodAnnotations($this->getReflectionMethod($method, $class));
    }

    /**
     * Get method annotation
     *
     * @param string $name
     * @param string $method
     * @param string $class
     * @return object|null
     * @throws \ReflectionException
     */
    public function getMethodAnnotation(string $name, string $method, string $class)
    {
        return $this->reader->getMethodAnnotation(
            $this->getReflectionMethod($method, $class),
            $name
        );
    }

    /**
     * Get all annotations of property
     *
     * @param string $property
     * @param string $class
     * @return array
     * @throws \ReflectionException
     */
    public function getPropertyAnnotations(string $property, string $class): array
    {
        return $this->reader->getPropertyAnnotations($this->getReflectionProperty($property, $class));
    }

    /**
     * Get property annotation
     *
     * @param string $name
     * @param string $property
     * @param string $class
     * @return object|null
     * @throws \ReflectionException
     */
    public function getPropertyAnnotation(string $name, string $property, string $class)
    {
        return $this->reader->getPropertyAnnotation(
            $this->getReflectionProperty($property, $class),
            $name
        );
    }

    /**
     * Get new ReflectionClass
     *
     * @param string $name
     * @return \ReflectionClass
     * @throws \ReflectionException
     */
    private function getReflectionClass(string $name): \ReflectionClass
    {
        return new \ReflectionClass($name);
    }

    /**
     * Get new ReflectionMethod
     *
     * @param string $name
     * @param string $class
     * @return \ReflectionMethod
     * @throws \ReflectionException
     */
    private function getReflectionMethod(string $name, string $class): \ReflectionMethod
    {
        return new \ReflectionMethod($class, $name);
    }

    /**
     * Get new ReflectionProperty
     *
     * @param string $name
     * @param string $class
     * @return \ReflectionProperty
     * @throws \ReflectionException
     */
    private function getReflectionProperty(string $name, string $class): \ReflectionProperty
    {
        return new \ReflectionProperty($class, $name);
    }
}
