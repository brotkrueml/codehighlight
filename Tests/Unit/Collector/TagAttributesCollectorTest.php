<?php

declare(strict_types=1);

/*
 * This file is part of the "codehighlight" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\CodeHighlight\Tests\Unit\Collector;

use Brotkrueml\CodeHighlight\Collector\TagAttributesCollector;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class TagAttributesCollectorTest extends TestCase
{
    /**
     * @test
     */
    public function toStringReturnsEmptyStringAfterInstantiation(): void
    {
        $subject = new TagAttributesCollector();

        self::assertSame('', $subject->__toString());
    }

    /**
     * @test
     */
    public function toStringReturnsOneAttributeCorrectly(): void
    {
        $subject = new TagAttributesCollector();

        $subject->setAttribute('some-attribute', 'some-value');

        self::assertSame('some-attribute="some-value"', $subject->__toString());
    }

    /**
     * @test
     */
    public function toStringReturnsTwoAttributesCorrectly(): void
    {
        $subject = new TagAttributesCollector();

        $subject->setAttribute('some-attribute', 'some-value');
        $subject->setAttribute('another-attribute', 'another-value');

        self::assertSame('some-attribute="some-value" another-attribute="another-value"', $subject->__toString());
    }

    /**
     * @test
     */
    public function attributesAreMaskedCorrectly(): void
    {
        $subject = new TagAttributesCollector();

        $subject->setAttribute('some-attribute"', 'some"<va&ue>"');

        self::assertSame('some-attribute"="some&quot;&lt;va&amp;ue&gt;&quot;"', $subject->__toString());
    }
}
