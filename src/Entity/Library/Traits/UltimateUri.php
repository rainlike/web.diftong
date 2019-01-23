<?php
/**
 * UltimateUri Trait
 * Provides method to get final URI
 *
 * @package App\Entity\Library\Traits
 * @version 1.0.0
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @copyright 2018 spbcrew.com (https://www.spbcrew.com)
 * @author Alexander Saveliev <alex@spbcrew.com>
 */
declare(strict_types=1);

namespace App\Entity\Library\Traits;

/** Trait UltimateUri */
trait UltimateUri
{
    /**
     * Get ultimate URI
     *
     * @return string|null
     */
    public function getUltimateUri(): ?string
    {
        return \property_exists($this, 'uri') && $this->uri
            ? $this->uri
            : $this->slug;
    }
}
