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
final class TagAttributeValuesCollector implements \Stringable
{
    /**
     * @var string[]
     */
    private array $values = [];

    public function addValue(string $value): void
    {
        $this->values[] = $value;
    }

    public function __toString(): string
    {
        return \htmlspecialchars(\implode(' ', $this->values));
    }
}
