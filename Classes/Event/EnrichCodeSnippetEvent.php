<?php

declare(strict_types=1);

/*
 * This file is part of the "codehighlight" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\CodeHighlight\Event;

use Brotkrueml\CodeHighlight\Collector\AssetCollector;
use Brotkrueml\CodeHighlight\Collector\TagAttributesCollector;
use Brotkrueml\CodeHighlight\Collector\TagAttributeValuesCollector;
use Brotkrueml\CodeHighlight\Configuration\Options;
use Brotkrueml\CodeHighlight\Configuration\SiteConfiguration;
use Psr\Http\Message\ServerRequestInterface;

/**
 * @internal
 */
final class EnrichCodeSnippetEvent
{
    public bool $hasSpecialLanguage = false;

    public function __construct(
        public readonly SiteConfiguration $siteConfiguration,
        public readonly Options $options,
        public readonly AssetCollector $stylesCollector,
        public readonly AssetCollector $scriptsCollector,
        public readonly TagAttributesCollector $preAttributesCollector,
        public readonly TagAttributeValuesCollector $preClassesCollector,
        public readonly TagAttributesCollector $codeAttributesCollector,
        public readonly TagAttributeValuesCollector $codeClassesCollector,
        public readonly ServerRequestInterface $request,
    ) {}
}
