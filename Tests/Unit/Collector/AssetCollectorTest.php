<?php

declare(strict_types=1);

/*
 * This file is part of the "codehighlight" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\CodeHighlight\Tests\Unit\Collector;

use Brotkrueml\CodeHighlight\Collector\AssetCollector;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class AssetCollectorTest extends TestCase
{
    #[Test]
    public function getPathsIsEmptyAfterInstantiation(): void
    {
        $subject = new AssetCollector();

        self::assertSame([], $subject->getPaths());
    }

    #[Test]
    public function addPathAndGetPaths(): void
    {
        $subject = new AssetCollector();

        $subject->addPath('some-path');
        $subject->addPath('another-path');

        self::assertCount(2, $subject->getPaths());
        self::assertSame('some-path', $subject->getPaths()[0]);
        self::assertSame('another-path', $subject->getPaths()[1]);
    }
}
