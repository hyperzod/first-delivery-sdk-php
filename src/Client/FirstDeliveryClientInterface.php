<?php

namespace Hyperzod\FirstDeliverySdkPhp\Client;

/**
 * Interface for a FirstDelivery client.
 */
interface FirstDeliveryClientInterface extends BaseFirstDeliveryClientInterface
{
   /**
    * Sends a request to FirstDelivery's API.
    *
    * @param string $method the HTTP method
    * @param string $path the path of the request
    * @param array $params the parameters of the request
    */
   public function request($method, $path, $params);
}
