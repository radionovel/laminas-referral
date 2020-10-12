<?php

namespace Radionovel\LaminasReferral\Service;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

/**
 * Class ReferralFactory.
 */
class ReferralFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string             $requestedName
     * @param array|null         $options
     *
     * @return object|ReferralService
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $request = $this->getRequest($container);
        $config = $this->getConfig($container);

        return new ReferralService($request, $config);
    }

    /**
     * @param ContainerInterface $container
     *
     * @return mixed
     */
    public function getRequest(ContainerInterface $container)
    {
        return $container->get('request');
    }

    /**
     * @param ContainerInterface $container
     *
     * @return array
     */
    public function getConfig(ContainerInterface $container)
    {
        $config = $container->get('config');

        return isset($config['referral']) ? $config['referral'] : [];
    }
}
