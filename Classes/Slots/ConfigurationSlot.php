<?php
declare(strict_types = 1);
namespace Bitmotion\Auth0\Slots;

/***
 *
 * This file is part of the "Auth0" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2018 Florian Wessels <f.wessels@Leuchtfeuer.com>, Leuchtfeuer Digital Marketing
 *
 ***/

use Bitmotion\Auth0\EventListener\AfterPackageActivation;
use TYPO3\CMS\Core\Configuration\ConfigurationManager;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * @deprecated Will be replaced by event listener
 * @see AfterPackageActivation
 */
class ConfigurationSlot
{
    protected $excludedParameters = [
        'code',
        'state',
        'error_description',
        'error',
    ];

    public function addCacheHashExcludedParameters(): void
    {
        $path = ['FE', 'cacheHash', 'excludedParameters'];
        $configurationManager = GeneralUtility::makeInstance(ConfigurationManager::class);
        $excludeParameters = $configurationManager->getConfigurationValueByPath($path);

        $this->setValues($excludeParameters);

        $configurationManager->setLocalConfigurationValueByPath($path, $excludeParameters);
    }

    protected function setValues(array &$excludeParameters): void
    {
        foreach ($this->excludedParameters as $excludedParameter) {
            if (!in_array($excludedParameter, $excludeParameters)) {
                $excludeParameters[] = $excludedParameter;
            }
        }
    }
}
