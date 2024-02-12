<?php

declare(strict_types=1);

/*
 * This file is part of the "codehighlight" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\CodeHighlight\Tests\Traits;

use Brotkrueml\CodeHighlight\Collector\AssetCollector;
use Brotkrueml\CodeHighlight\Collector\TagAttributesCollector;
use Brotkrueml\CodeHighlight\Collector\TagAttributeValuesCollector;
use Brotkrueml\CodeHighlight\Configuration\Options;
use Brotkrueml\CodeHighlight\Configuration\SiteConfiguration;
use Brotkrueml\CodeHighlight\Event\EnrichCodeSnippetEvent;
use Psr\Http\Message\ServerRequestInterface;

trait CreateEnrichCodeSnippetEventTrait
{
    private function createEnrichCodeSnippetEvent(
        SiteConfiguration $siteConfiguration,
        Options $options,
        ServerRequestInterface $request,
    ): EnrichCodeSnippetEvent {
        return new EnrichCodeSnippetEvent(
            $siteConfiguration,
            $options,
            new AssetCollector(),
            new AssetCollector(),
            new TagAttributesCollector(),
            new TagAttributeValuesCollector(),
            new TagAttributesCollector(),
            new TagAttributeValuesCollector(),
            $request,
        );
    }
}
