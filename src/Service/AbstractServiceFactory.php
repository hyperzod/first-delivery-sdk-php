<?php

namespace Hyperzod\FirstDeliverySdkPhp\Service;

/**
 * Abstract base class for all service factories used to expose service
 * instances through {@link \Hyperzod\FirstDeliverySdkPhp\Client\FirstDeliveryClient}.
 *
 * Service factories serve two purposes:
 *
 * 1. Expose properties for all services through the `__get()` magic method.
 * 2. Lazily initialize each service instance the first time the property for
 *    a given service is used.
 */
abstract class AbstractServiceFactory
{
    /** @var \Hyperzod\FirstDeliverySdkPhp\Client\FirstDeliveryClientInterface */
    private $client;

    /** @var array<string, AbstractService|AbstractServiceFactory> */
    private $services;

    /**
     * @param \Hyperzod\FirstDeliverySdkPhp\Client\FirstDeliveryClientInterface $client
     */
    public function __construct($client)
    {
        $this->client = $client;
        $this->services = [];
    }

    /**
     * @param string $name
     *
     * @return null|string
     */
    abstract protected function getServiceClass($name);

    /**
     * @param string $name
     *
     * @return null|AbstractService|AbstractServiceFactory
     */
    public function __get($name)
    {
        $serviceClass = $this->getServiceClass($name);
        if (null !== $serviceClass) {
            if (!\array_key_exists($name, $this->services)) {
                $this->services[$name] = new $serviceClass($this->client);
            }

            return $this->services[$name];
        }

        \trigger_error('Undefined property: ' . static::class . '::$' . $name);

        return null;
    }
}
