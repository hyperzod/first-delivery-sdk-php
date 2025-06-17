<?php

namespace Hyperzod\FirstDeliverySdkPhp\Service;

use Hyperzod\FirstDeliverySdkPhp\Enums\HttpMethodEnum;

class JobService extends AbstractService
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
      return $this->request(HttpMethodEnum::POST, '/jobs', $params);
   }
}
