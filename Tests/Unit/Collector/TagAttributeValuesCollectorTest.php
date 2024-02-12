<?php

declare(strict_types=1);

/*
 * This file is part of the "codehighlight" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\CodeHighlight\Tests\Unit\Collector;

use Brotkrueml\CodeHighlight\Collector\TagAttributeValuesCollector;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class TagAttributeValuesCollectorTest extends TestCase
{
    #[Test]
    public function toStringReturnsEmptyStringAfterInstantiation(): void
    {
        $subject = new TagAttributeValuesCollector();

        self::assertSame('', $subject->__toString());
    }

    #[Test]
    public function toStringReturnsOneValueCorrectly(): void
    {
        $subject = new TagAttributeValuesCollector();

        $subject->addValue('some-value');

        self::assertSame('some-value', $subject->__toString());
    }

    #[Test]
    public function toStringReturnsTwoValueCorrectly(): void
    {
        $subject = new TagAttributeValuesCollector();

        $subject->addValue('some-value');
        $subject->addValue('another-value');

        self::assertSame('some-value another-value', $subject->__toString());
    }

    #[Test]
    public function valuesAreMaskedCorrectly(): void
    {
        $subject = new TagAttributeValuesCollector();

        $subject->addValue('some<va&"lue>');

        self::assertSame('some&lt;va&amp;&quot;lue&gt;', $subject->__toString());
    }
}
