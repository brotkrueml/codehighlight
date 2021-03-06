<?php

declare(strict_types=1);

/*
 * This file is part of the "codehighlight" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\CodeHighlight\DataProcessing;

use TYPO3\CMS\Core\Service\FlexFormService;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Frontend\ContentObject\DataProcessorInterface;

if (\class_exists(\TYPO3\CMS\Frontend\DataProcessing\FlexFormProcessor::class)) {
    // since TYPO3 v11.1
    class FlexFormProcessor extends \TYPO3\CMS\Frontend\DataProcessing\FlexFormProcessor
    {
    }
} else {
    /**
     * This data processor can be used for processing data for the content elements which have flexform contents in one field
     *
     * Example TypoScript configuration:
     * 10 = Brotkrueml\CodeHighlight\DataProcessing\FlexFormProcessor
     * 10 {
     *   if.isTrue.field = pi_flexform
     *   fieldName = pi_flexform
     *   as = flexform
     * }
     *
     * whereas "flexform" can be used as a variable {flexform} inside Fluid to fetch values.
     *
     * @internal
     */
    class FlexFormProcessor implements DataProcessorInterface
    {
        /** @var FlexFormService */
        private $flexFormService;

        public function __construct(FlexFormService $flexFormService = null)
        {
            $this->flexFormService = $flexFormService ?? GeneralUtility::makeInstance(FlexFormService::class);
        }

        public function process(
            ContentObjectRenderer $contentObjectRenderer,
            array $contentObjectConfiguration,
            array $processorConfiguration,
            array $processedData
        ): array {
            if (isset($processorConfiguration['if.']) && !$contentObjectRenderer->checkIf($processorConfiguration['if.'])) {
                return $processedData;
            }

            $targetVariableName = $contentObjectRenderer->stdWrapValue('as', $processorConfiguration, 'flexform');
            $fieldName = $contentObjectRenderer->stdWrapValue('fieldName', $processorConfiguration, 'pi_flexform');

            $processedData[$targetVariableName] = $this->flexFormService->convertFlexFormContentToArray($contentObjectRenderer->data[$fieldName]);

            return $processedData;
        }
    }
}
