<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 *
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Radionovel\LaminasReferral;

use Radionovel\LaminasReferral\Service\ReferralFactory;

/**
 * Class Module.
 */
class Module
{
    public function getConfig()
    {
        return [
            'referral'        => [],
            'service_manager' => [
                'factories' => [
                    'referral' => ReferralFactory::class,
                ],
            ],
        ];
    }
}
