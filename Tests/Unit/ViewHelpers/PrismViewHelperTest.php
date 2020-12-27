<?php

declare(strict_types=1);

/*
 * This file is part of the "codehighlight" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\CodeHighlight\Tests\Unit\ViewHelpers;

use Brotkrueml\CodeHighlight\ViewHelpers\PrismViewHelper;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContext;

class PrismViewHelperTest extends TestCase
{
    /** @var MockObject|RenderingContext */
    private $renderingContextMock;

    /** @var MockObject|PageRenderer */
    private $pageRendererMock;

    /** @var PrismViewHelper */
    private $subject;

    protected function setUp(): void
    {
        $this->renderingContextMock = $this->createMock(RenderingContext::class);
        $this->pageRendererMock = $this->createMock(PageRenderer::class);
        $this->subject = new PrismViewHelper();
        $this->subject->setPageRenderer($this->pageRendererMock);
    }

    /**
     * @test
     */
    public function argumentsAreRegisteredCorrectly(): void
    {
        /** @var MockObject|PrismViewHelper $subject */
        $subject = $this->getMockBuilder(PrismViewHelper::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['registerArgument'])
            ->getMock();

        $subject
            ->expects(self::exactly(4))
            ->method('registerArgument')
            ->withConsecutive(
                ['configuration', 'array', self::anything(), false, []],
                ['options', 'array', self::anything(), false, []],
                ['id', 'string', self::anything(), false, ''],
                ['snippet', 'string', self::anything(), false, '']
            );

        $subject->initializeArguments();
    }

    /**
     * @test
     * @dataProvider dataProviderForArgumentsReturningResultSets
     * @param array $arguments
     * @param string $expected
     */
    public function argumentResultSetIsReturnedCorrectly(array $arguments, string $expected): void
    {
        $actual = $this->subject->renderStatic(
            $arguments,
            function () {
            },
            $this->renderingContextMock
        );

        self::assertSame($expected, $actual);
    }

    public function dataProviderForArgumentsReturningResultSets(): iterable
    {
        yield 'With no arguments given' => [
            [],
            '',
        ];

        yield 'With only snippet given' => [
            [
                'snippet' => 'some code snippet',
            ],
            '<pre><code class="language-none">some code snippet</code></pre>',
        ];

        yield 'With programming language given' => [
            [
                'options' => [
                    'programmingLanguage' => 'php',
                ],
                'snippet' => 'some code snippet',
            ],
            '<pre><code class="language-php">some code snippet</code></pre>',
        ];

        yield 'With activated line numbers' => [
            [
                'options' => [
                    'showLineNumbers' => '1',
                ],
                'snippet' => 'some code snippet',
            ],
            '<pre class="line-numbers"><code class="language-none">some code snippet</code></pre>',
        ];

        yield 'With activated line numbers and startWithLineNumber' => [
            [
                'options' => [
                    'showLineNumbers' => '1',
                    'startWithLineNumber' => '5',
                ],
                'snippet' => 'some code snippet',
            ],
            '<pre data-start="5" class="line-numbers"><code class="language-none">some code snippet</code></pre>',
        ];

        yield 'With deactivated line numbers and startWithLineNumber' => [
            [
                'options' => [
                    'showLineNumbers' => '0',
                    'startWithLineNumber' => '5',
                ],
                'snippet' => 'some code snippet',
            ],
            '<pre><code class="language-none">some code snippet</code></pre>',
        ];

        yield 'With highlightLines' => [
            [
                'options' => [
                    'highlightLines' => '4-7',
                ],
                'snippet' => 'some code snippet',
            ],
            '<pre data-line="4-7"><code class="language-none">some code snippet</code></pre>',
        ];

        yield 'With highlightLines and startWithLineNumber' => [
            [
                'options' => [
                    'highlightLines' => '4-7',
                    'startWithLineNumber' => '3',
                ],
                'snippet' => 'some code snippet',
            ],
            '<pre data-line="4-7" data-line-offset="2"><code class="language-none">some code snippet</code></pre>',
        ];

        yield 'With activated command line and commandLineServerPrompt' => [
            [
                'options' => [
                    'displayCommandLine' => '1',
                    'commandLineServerPrompt' => 'C:\Users\Chris',
                ],
                'snippet' => 'some code snippet',
            ],
            '<pre data-prompt="C:\Users\Chris" class="command-line"><code class="language-none">some code snippet</code></pre>',
        ];

        yield 'With activated command line and commandLineServerUser' => [
            [
                'options' => [
                    'displayCommandLine' => '1',
                    'commandLineServerUser' => 'chris',
                ],
                'snippet' => 'some code snippet',
            ],
            '<pre data-user="chris" class="command-line"><code class="language-none">some code snippet</code></pre>',
        ];

        yield 'With activated command line and commandLineServerHost' => [
            [
                'options' => [
                    'displayCommandLine' => '1',
                    'commandLineServerHost' => 'earth',
                ],
                'snippet' => 'some code snippet',
            ],
            '<pre data-host="earth" class="command-line"><code class="language-none">some code snippet</code></pre>',
        ];

        yield 'With activated command line and defaultServerUser' => [
            [
                'configuration' => [
                    'codehighlightCommandLineDefaultUser' => 'defaultChris',
                ],
                'options' => [
                    'displayCommandLine' => '1',
                ],
                'snippet' => 'some code snippet',
            ],
            '<pre data-user="defaultChris" class="command-line"><code class="language-none">some code snippet</code></pre>',
        ];

        yield 'With activated command line and commandLineServerUser/defaultServerUser' => [
            [
                'configuration' => [
                    'codehighlightCommandLineDefaultUser' => 'defaultChris',
                ],
                'options' => [
                    'displayCommandLine' => '1',
                    'commandLineServerUser' => 'chris',
                ],
                'snippet' => 'some code snippet',
            ],
            '<pre data-user="chris" class="command-line"><code class="language-none">some code snippet</code></pre>',
        ];

        yield 'With activated command line and defaultServerHost' => [
            [
                'configuration' => [
                    'codehighlightCommandLineDefaultHost' => 'defaultEarth',
                ],
                'options' => [
                    'displayCommandLine' => '1',
                ],
                'snippet' => 'some code snippet',
            ],
            '<pre data-host="defaultEarth" class="command-line"><code class="language-none">some code snippet</code></pre>',
        ];

        yield 'With activated command line and commandLineServerHost/defaultServerHost' => [
            [
                'configuration' => [
                    'codehighlightCommandLineDefaultHost' => 'defaultEarth',
                ],
                'options' => [
                    'displayCommandLine' => '1',
                    'commandLineServerHost' => 'earth',
                ],
                'snippet' => 'some code snippet',
            ],
            '<pre data-host="earth" class="command-line"><code class="language-none">some code snippet</code></pre>',
        ];

        yield 'With activated command line and commandLineOutputLines' => [
            [
                'options' => [
                    'displayCommandLine' => '1',
                    'commandLineOutputLines' => '5-7',
                ],
                'snippet' => 'some code snippet',
            ],
            '<pre data-output="5-7" class="command-line"><code class="language-none">some code snippet</code></pre>',
        ];

        yield 'With activated command line and commandLineOutputFilter' => [
            [
                'options' => [
                    'displayCommandLine' => '1',
                    'commandLineOutputFilter' => '(out)',
                ],
                'snippet' => 'some code snippet',
            ],
            '<pre data-filter-output="(out)" class="command-line"><code class="language-none">some code snippet</code></pre>',
        ];

        yield 'With deactivated command line and commandLineServerPrompt' => [
            [
                'options' => [
                    'displayCommandLine' => '0',
                    'commandLineOutputFilter' => 'C:\Users\Chris',
                ],
                'snippet' => 'some code snippet',
            ],
            '<pre><code class="language-none">some code snippet</code></pre>',
        ];

        yield 'With deactivated command line and commandLineServerUser' => [
            [
                'options' => [
                    'displayCommandLine' => '0',
                    'commandLineServerUser' => 'chris',
                ],
                'snippet' => 'some code snippet',
            ],
            '<pre><code class="language-none">some code snippet</code></pre>',
        ];

        yield 'With deactivated command line and commandLineServerHost' => [
            [
                'options' => [
                    'displayCommandLine' => '0',
                    'commandLineServerUser' => 'earth',
                ],
                'snippet' => 'some code snippet',
            ],
            '<pre><code class="language-none">some code snippet</code></pre>',
        ];

        yield 'With deactivated command line and commandLineOutputLines' => [
            [
                'options' => [
                    'displayCommandLine' => '0',
                    'commandLineOutputLines' => '5-8',
                ],
                'snippet' => 'some code snippet',
            ],
            '<pre><code class="language-none">some code snippet</code></pre>',
        ];

        yield 'With deactivated command line and commandLineOutputFilter' => [
            [
                'options' => [
                    'displayCommandLine' => '0',
                    'commandLineOutputFilter' => '(out)',
                ],
                'snippet' => 'some code snippet',
            ],
            '<pre><code class="language-none">some code snippet</code></pre>',
        ];

        yield 'With activated inline colour for CSS, css-extras is added' => [
            [
                'options' => [
                    'programmingLanguage' => 'css',
                    'inlineColour' => '1',
                ],
                'snippet' => 'some code snippet',
            ],
            '<pre><code class="language-css-extras language-css">some code snippet</code></pre>',
        ];

        yield 'With activated inline colour for HTML, css-extras is added' => [
            [
                'options' => [
                    'programmingLanguage' => 'html',
                    'inlineColour' => '1',
                ],
                'snippet' => 'some code snippet',
            ],
            '<pre><code class="language-css-extras language-html">some code snippet</code></pre>',
        ];

        yield 'With activated inline colour for PHP, css-extras is not added' => [
            [
                'options' => [
                    'programmingLanguage' => 'php',
                    'inlineColour' => '1',
                ],
                'snippet' => 'some code snippet',
            ],
            '<pre><code class="language-php">some code snippet</code></pre>',
        ];

        yield 'With deactivated inline colour for CSS, css-extras is not added' => [
            [
                'options' => [
                    'programmingLanguage' => 'css',
                    'inlineColour' => '0',
                ],
                'snippet' => 'some code snippet',
            ],
            '<pre><code class="language-css">some code snippet</code></pre>',
        ];

        yield 'Special characters in attribute values are masked' => [
            [
                'options' => [
                    'programmingLanguage' => '>php<',
                    'showLineNumbers' => '1',
                    'startWithLineNumber' => '<"5">',
                    'highlightLines' => '<"3-8">',
                    'displayCommandLine' => '1',
                    'commandLineServerPrompt' => '<C:"Users"Chris">',
                    'commandLineOutputLines' => '<"23">',
                    'commandLineOutputFilter' => '>out<',
                ],
                'snippet' => 'some code snippet',
            ],
            '<pre data-start="&lt;&quot;5&quot;&gt;" data-line="&lt;&quot;3-8&quot;&gt;" data-output="&lt;&quot;23&quot;&gt;" data-filter-output="&gt;out&lt;" data-prompt="&lt;C:&quot;Users&quot;Chris&quot;&gt;" class="line-numbers command-line"><code class="language-&gt;php&lt;">some code snippet</code></pre>',
        ];

        yield 'Special characters in attribute values are masked 2' => [
            [
                'options' => [
                    'displayCommandLine' => '1',
                    'commandLineServerUser' => '>"chris"<',
                    'commandLineServerHost' => '>"host"<',
                ],
                'snippet' => 'some code snippet',
            ],
            '<pre data-user="&gt;&quot;chris&quot;&lt;" data-host="&gt;&quot;host&quot;&lt;" class="command-line"><code class="language-none">some code snippet</code></pre>',
        ];

        yield 'Special characters in attribute values are masked 3' => [
            [
                'configuration' => [
                    'codehighlightCommandLineDefaultHost' => '>"host"<',
                    'codehighlightCommandLineDefaultUser' => '>"chris"<',
                ],
                'options' => [
                    'displayCommandLine' => '1',
                ],
                'snippet' => 'some code snippet',
            ],
            '<pre data-user="&gt;&quot;chris&quot;&lt;" data-host="&gt;&quot;host&quot;&lt;" class="command-line"><code class="language-none">some code snippet</code></pre>',
        ];

        yield 'Special characters in snippet are masked' => [
            [
                'snippet' => '<h1>some "code snippet"</h1>',
            ],
            '<pre><code class="language-none">&lt;h1&gt;some &quot;code snippet&quot;&lt;/h1&gt;</code></pre>',
        ];
    }

    /**
     * @test
     */
    public function noAssetsAreAddedWhenSnippetIsEmpty(): void
    {
        $this->pageRendererMock
            ->expects(self::never())
            ->method('addCssFile');

        $this->pageRendererMock
            ->expects(self::never())
            ->method('addJsFooterFile');

        $this->subject->renderStatic(
            [],
            function () {
            },
            $this->renderingContextMock
        );
    }

    /**
     * @test
     */
    public function themeFileIsAddedCorrectlyWhenNoThemeIsGiven(): void
    {
        $this->pageRendererMock
            ->expects(self::once())
            ->method('addCssFile')
            ->with($this->buildAssetPath('themes/prism.css'));

        $this->subject->renderStatic(
            [
                'snippet' => 'some code snippet',
            ],
            function () {
            },
            $this->renderingContextMock
        );
    }

    private function buildAssetPath(string $asset): string
    {
        return 'EXT:codehighlight/Resources/Public/Prism/' . $asset;
    }

    /**
     * @test
     */
    public function themeFileIsAddedCorrectlyWhenConcreteThemeIsGiven(): void
    {
        $this->pageRendererMock
            ->expects(self::once())
            ->method('addCssFile')
            ->with('/some-theme.css');

        $this->subject->renderStatic(
            [
                'snippet' => 'some code snippet',
                'configuration' => [
                    'codehighlightTheme' => '/some-theme.css',
                ],
            ],
            function () {
            },
            $this->renderingContextMock
        );
    }

    /**
     * @test
     */
    public function mainAssetScriptsAreAddedCorrectly(): void
    {
        $this->pageRendererMock
            ->expects(self::exactly(2))
            ->method('addJsFooterFile')
            ->withConsecutive(
                [$this->buildAssetPath('components/prism-core.min.js')],
                [$this->buildAssetPath('plugins/autoloader/prism-autoloader.min.js')]
            );

        $this->subject->renderStatic(
            [
                'snippet' => 'some code snippet',
            ],
            function () {
            },
            $this->renderingContextMock
        );
    }

    /**
     * @test
     * @dataProvider dataProviderForAssets
     * @param array $arguments
     * @param string $addedCss
     * @param string $addedJs
     */
    public function lineNumberAssetsAreAddedCorrectly(array $arguments, string $addedCss, string $addedJs): void
    {
        $this->pageRendererMock
            ->expects(self::exactly(2))
            ->method('addCssFile')
            ->withConsecutive(
                [self::anything()],
                [$addedCss]
            );

        $this->pageRendererMock
            ->expects(self::exactly(3))
            ->method('addJsFooterFile')
            ->withConsecutive(
                [self::anything()],
                [self::anything()],
                [$addedJs]
            );

        $this->subject->renderStatic(
            $arguments,
            function () {
            },
            $this->renderingContextMock
        );
    }

    public function dataProviderForAssets(): iterable
    {
        yield 'Option showLineNumber is activated' => [
            [
                'options' => [
                    'showLineNumbers' => '1',
                ],
                'snippet' => 'some code snippet',
            ],
            $this->buildAssetPath('plugins/line-numbers/prism-line-numbers.css'),
            $this->buildAssetPath('plugins/line-numbers/prism-line-numbers.min.js'),
        ];

        yield 'Option highlightLines is used' => [
            [
                'options' => [
                    'highlightLines' => '4-7',
                ],
                'snippet' => 'some code snippet',
            ],
            $this->buildAssetPath('plugins/line-highlight/prism-line-highlight.css'),
            $this->buildAssetPath('plugins/line-highlight/prism-line-highlight.min.js'),
        ];

        yield 'Configuration codehighlightUseUrlHash is activated' => [
            [
                'configuration' => [
                    'codehighlightUseUrlHash' => true,
                ],
                'snippet' => 'some code snippet',
            ],
            $this->buildAssetPath('plugins/line-highlight/prism-line-highlight.css'),
            $this->buildAssetPath('plugins/line-highlight/prism-line-highlight.min.js'),
        ];

        yield 'Option displayCommandLine is activated' => [
            [
                'options' => [
                    'displayCommandLine' => '1',
                ],
                'snippet' => 'some code snippet',
            ],
            $this->buildAssetPath('plugins/command-line/prism-command-line.css'),
            $this->buildAssetPath('plugins/command-line/prism-command-line.min.js'),
        ];
    }
}
