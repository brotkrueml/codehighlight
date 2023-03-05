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
    /**
     * @readonly
     */
    public SiteConfiguration $siteConfiguration;
    /**
     * @readonly
     */
    public Options $options;
    /**
     * @readonly
     */
    public AssetCollector $stylesCollector;
    /**
     * @readonly
     */
    public AssetCollector $scriptsCollector;
    /**
     * @readonly
     */
    public TagAttributesCollector $preAttributesCollector;
    /**
     * @readonly
     */
    public TagAttributeValuesCollector $preClassesCollector;
    /**
     * @readonly
     */
    public TagAttributesCollector $codeAttributesCollector;
    /**
     * @readonly
     */
    public TagAttributeValuesCollector $codeClassesCollector;
    /**
     * @readonly
     */
    public ServerRequestInterface $request;
    public bool $hasSpecialLanguage = false;

    public function __construct(
        SiteConfiguration $siteConfiguration,
        Options $options,
        AssetCollector $stylesCollector,
        AssetCollector $scriptsCollector,
        TagAttributesCollector $preAttributesCollector,
        TagAttributeValuesCollector $preClassesCollector,
        TagAttributesCollector $codeAttributesCollector,
        TagAttributeValuesCollector $codeClassesCollector,
        ServerRequestInterface $request
    ) {
        $this->siteConfiguration = $siteConfiguration;
        $this->options = $options;
        $this->stylesCollector = $stylesCollector;
        $this->scriptsCollector = $scriptsCollector;
        $this->preAttributesCollector = $preAttributesCollector;
        $this->preClassesCollector = $preClassesCollector;
        $this->codeAttributesCollector = $codeAttributesCollector;
        $this->codeClassesCollector = $codeClassesCollector;
        $this->request = $request;
    }
}
