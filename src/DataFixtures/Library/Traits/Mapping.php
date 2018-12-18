<?php
declare(strict_types=1);

namespace App\DataFixtures\Library\Traits;

/**
 * Trait Mapping
 *
 * @package App\DataFixtures\Library\Traits
 */
trait Mapping
{
    /**
     * Get mapping
     *
     * @param string $key
     * @return string|null
     */
    private function mapping(string $key): ?string
    {
        $mapping = [
            'formatted_content' => 'formattedContent'
        ];

        return $mapping[$key] ?? null;
    }
}
