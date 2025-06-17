<?php

namespace Hyperzod\FirstDeliverySdkPhp\Client;

/**
 * Interface for a FirstDelivery client.
 */
interface BaseFirstDeliveryClientInterface
{
   /**
    * Gets the API key used by the client to send requests.
    *
    * @return null|string the API key used by the client to send requests
    */
   public function getApiKey();

   /**
    * Gets the base URL for FirstDelivery's API.
    *
    * @return string the base URL for FirstDelivery's API
    */
   public function getApiBase();
}
