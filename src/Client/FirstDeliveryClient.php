<?php

namespace Hyperzod\FirstDeliverySdkPhp\Client;

use Hyperzod\FirstDeliverySdkPhp\Service\CoreServiceFactory;

class FirstDeliveryClient extends BaseFirstDeliveryClient
{
    /**
     * @var CoreServiceFactory
     */
    private $coreServiceFactory;

    public function __get($name)
    {
        if (null === $this->coreServiceFactory) {
            $this->coreServiceFactory = new CoreServiceFactory($this);
        }

        return $this->coreServiceFactory->__get($name);
    }
}
