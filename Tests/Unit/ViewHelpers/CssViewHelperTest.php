<?php

declare(strict_types=1);

/*
 * This file is part of the "codehighlight" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\CodeHighlight\Tests\Unit\ViewHelpers;

use Brotkrueml\CodeHighlight\ViewHelpers\CssViewHelper;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContext;

class CssViewHelperTest extends TestCase
{
    /**
     * @var MockObject&RenderingContext
     */
    private MockObject $renderingContextMock;
    /**
     * @var MockObject&PageRenderer
     */
    private MockObject $pageRendererMock;
    private CssViewHelper $subject;

    protected function setUp(): void
    {
        $this->renderingContextMock = $this->createMock(RenderingContext::class);
        $this->pageRendererMock = $this->createMock(PageRenderer::class);
        $this->subject = new CssViewHelper();
        $this->subject->setPageRenderer($this->pageRendererMock);
    }

    /**
     * @test
     */
    public function argumentsAreRegisteredCorrectly(): void
    {
        /** @var MockObject|CssViewHelper $subject */
        $subject = $this->getMockBuilder(CssViewHelper::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['registerArgument'])
            ->getMock();

        $subject
            ->expects(self::once())
            ->method('registerArgument')
            ->with('path', 'string', self::anything(), true);

        $subject->initializeArguments();
    }

    /**
     * @test
     */
    public function givenEmptyPathDoesNothing(): void
    {
        $this->pageRendererMock
            ->expects(self::never())
            ->method('addCssFile');

        $this->subject->renderStatic(
            [
                'path' => '',
            ],
            static function (): void {
            },
            $this->renderingContextMock
        );
    }

    /**
     * @test
     */
    public function givenPathAddsCssFileCorrectly(): void
    {
        $this->pageRendererMock
            ->expects(self::once())
            ->method('addCssFile')
            ->with('some_styles.css');

        $this->subject->renderStatic(
            [
                'path' => 'some_styles.css',
            ],
            static function (): void {
            },
            $this->renderingContextMock
        );
    }
}
