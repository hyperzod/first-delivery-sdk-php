<?php

namespace Hyperzod\FirstDeliverySdkPhp\Service;

use Hyperzod\FirstDeliverySdkPhp\Enums\HttpMethodEnum;

class OrderService extends AbstractService
{
   /**
    * Create a job on FirstDelivery
    *
    * @param array $params
    *
    * @throws \Hyperzod\FirstDeliverySdkPhp\Exception\ApiErrorException if the request fails
    *
    */
   public function create(array $params)
   {
      return $this->request(HttpMethodEnum::POST, 'v3/orders', $params);
   }
}
