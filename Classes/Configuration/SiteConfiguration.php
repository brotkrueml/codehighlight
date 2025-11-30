<?php

declare(strict_types=1);

/*
 * This file is part of the "codehighlight" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\CodeHighlight\Configuration;

/**
 * The data transfer object is derived from the site configuration
 * @internal
 */
final readonly class SiteConfiguration
{
    public string $commandLineDefaultHost;
    public string $commandLineDefaultUser;
    public string $theme;
    public bool $toolbarCopyToClipboard;
    public bool $useUrlHash;

    /**
     * @param array<string, string> $fullConfiguration
     */
    public function __construct(array $fullConfiguration)
    {
        $this->theme = $fullConfiguration['codehighlightTheme'] ?? '';
        $this->commandLineDefaultHost = $fullConfiguration['codehighlightCommandLineDefaultHost'] ?? '';
        $this->commandLineDefaultUser = $fullConfiguration['codehighlightCommandLineDefaultUser'] ?? '';
        $this->toolbarCopyToClipboard = (bool) ($fullConfiguration['codehighlightToolbarCopyToClipboard'] ?? false);
        $this->useUrlHash = (bool) ($fullConfiguration['codehighlightUseUrlHash'] ?? false);
    }
}
