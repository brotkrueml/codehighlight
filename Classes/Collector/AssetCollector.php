<?php

declare(strict_types=1);

/*
 * This file is part of the "codehighlight" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\CodeHighlight\Collector;

/**
 * @internal
 */
final class AssetCollector
{
    /**
     * @var string[]
     */
    private array $paths = [];

    public function addPath(string $path): void
    {
        $this->paths[] = $path;
    }

    /**
     * @return string[]
     */
    public function getPaths(): array
    {
        return $this->paths;
    }
}
