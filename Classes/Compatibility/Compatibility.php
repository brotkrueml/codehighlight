<?php

declare(strict_types=1);

/*
 * This file is part of the "codehighlight" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\CodeHighlight\Compatibility;

use TYPO3\CMS\Core\Information\Typo3Version;

/**
 * @internal
 */
final class Compatibility
{
    /**
     * @var int
     */
    private $majorVersion;

    /**
     * @param int|null $majorVersion For testing purposes only!
     */
    public function __construct(int $majorVersion = null)
    {
        $this->majorVersion = $majorVersion ?? (new Typo3Version())->getMajorVersion();
    }

    public function hasIconsConfigurationFile(): bool
    {
        return $this->majorVersion >= 11;
    }

    public function hasFlexFormProcessor(): bool
    {
        return $this->majorVersion >= 11;
    }
}
