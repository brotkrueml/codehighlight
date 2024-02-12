<?php

declare(strict_types=1);

/*
 * This file is part of the "codehighlight" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use Brotkrueml\CodeHighlight\Extension;
use TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider;

return [
    'content-codehighlight' => [
        'provider' => SvgIconProvider::class,
        'source' => 'EXT:' . Extension::KEY . '/Resources/Public/Icons/content-codehighlight.svg',
    ],
];
