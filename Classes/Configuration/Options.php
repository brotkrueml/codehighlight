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
 * The options data transfer object is derived from the FlexForm settings
 * of a code snippet content element
 * @internal
 */
final readonly class Options
{
    public string $programmingLanguage;
    public string $filename;
    public bool $showLineNumbers;
    public int $startWithLineNumber;
    public string $highlightLines;
    public bool $displayCommandLine;
    public string $commandLineServerUser;
    public string $commandLineServerHost;
    public string $commandLineServerPrompt;
    public string $commandLineOutputLines;
    public string $commandLineOutputFilter;
    public bool $inlineColour;
    public bool $treeview;

    /**
     * @param array<string, string> $options
     */
    public function __construct(array $options)
    {
        $this->programmingLanguage = $options['programmingLanguage'] ?? '';
        $this->filename = $options['filename'] ?? '';
        $this->showLineNumbers = (bool) ($options['showLineNumbers'] ?? false);
        $this->startWithLineNumber = (int) ($options['startWithLineNumber'] ?? 0);
        $this->highlightLines = $options['highlightLines'] ?? '';
        $this->displayCommandLine = (bool) ($options['displayCommandLine'] ?? false);
        $this->commandLineServerUser = $options['commandLineServerUser'] ?? '';
        $this->commandLineServerHost = $options['commandLineServerHost'] ?? '';
        $this->commandLineServerPrompt = $options['commandLineServerPrompt'] ?? '';
        $this->commandLineOutputLines = $options['commandLineOutputLines'] ?? '';
        $this->commandLineOutputFilter = $options['commandLineOutputFilter'] ?? '';
        $this->inlineColour = (bool) ($options['inlineColour'] ?? false);
        $this->treeview = (bool) ($options['treeview'] ?? false);
    }
}
