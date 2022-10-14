<?php

declare(strict_types=1);

/*
 * This file is part of the "codehighlight" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\CodeHighlight\Collector;

use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * @internal
 */
final class TagAttributesCollector implements \Stringable
{
    /**
     * @var array<string, string>
     */
    private array $attributes = [];

    public function setAttribute(string $attribute, string $value): void
    {
        $this->attributes[$attribute] = $value;
    }

    public function __toString(): string
    {
        return GeneralUtility::implodeAttributes($this->attributes, true);
    }
}
