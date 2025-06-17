<?php

namespace Hyperzod\FirstDeliverySdkPhp\Client;

use Exception;
use GuzzleHttp\Client;
use Hyperzod\FirstDeliverySdkPhp\Exception\InvalidArgumentException;

class BaseFirstDeliveryClient implements FirstDeliveryClientInterface
{

   /** @var array<string, mixed> */
   private $config;

   /**
    * Initializes a new instance of the {@link BaseFirstDeliveryClient} class.
    *
    * The constructor takes two arguments.
    * @param string $api_key the API key of the client
    * @param string $api_base the base URL for FirstDelivery's API
    */

   public function __construct($api_key, $api_base)
   {
      $config = $this->validateConfig(array(
         "api_key" => $api_key,
         "api_base" => $api_base
      ));

      $this->config = $config;
   }

   /**
    * Gets the API key used by the client to send requests.
    *
    * @return null|string the API key used by the client to send requests
    */
   public function getApiKey()
   {
      return $this->config['api_key'];
   }

   /**
    * Gets the base URL for FirstDelivery's API.
    *
    * @return string the base URL for FirstDelivery's API
    */
   public function getApiBase()
   {
      return $this->config['api_base'];
   }

   /**
    * Sends a request to FirstDelivery's API.
    *
    * @param string $method the HTTP method
    * @param string $path the path of the request
    * @param array $params the parameters of the request
    */

   public function request($method, $path, $params)
   {
      $client = new Client([
         'headers' => [
            'content-type' => 'application/json',
            'Authorization' => 'Bearer ' . $this->getApiKey()
         ]
      ]);

      $api = $this->getApiBase() . $path;

      $response = $client->request($method, $api, [
         'http_errors' => true,
         'body' => json_encode($params)
      ]);

      return $this->validateResponse($response);
   }

   /**
    * @param array<string, mixed> $config
    *
    * @throws InvalidArgumentException
    */
   private function validateConfig($config)
   {
      // api_key
      if (!isset($config['api_key'])) {
         throw new InvalidArgumentException('api_key field is required');
      }

      if (!is_string($config['api_key'])) {
         throw new InvalidArgumentException('api_key must be a string');
      }

      if ('' === $config['api_key']) {
         throw new InvalidArgumentException('api_key cannot be an empty string');
      }

      if (preg_match('/\s/', $config['api_key'])) {
         throw new InvalidArgumentException('api_key cannot contain whitespace');
      }

      if (!isset($config['api_base'])) {
         throw new InvalidArgumentException('api_base field is required');
      }

      if (!is_string($config['api_base'])) {
         throw new InvalidArgumentException('api_base must be a string');
      }

      if ('' === $config['api_base']) {
         throw new InvalidArgumentException('api_base cannot be an empty string');
      }

      return [
         "api_key" => $config['api_key'],
         "api_base" => $config['api_base'],
      ];
   }

   private function validateResponse($response)
   {
      $status_code = $response->getStatusCode();

      $body = json_decode($response->getBody(), true);

      if ($status_code >= 200 && $status_code < 300) {
         if (isset($body['type']) && $body['type'] === 'success') {
            return $body;
         }
         if (isset($body['errors']) && is_array($body['errors']) && count($body['errors']) > 0) {
            throw new Exception($body['errors'][0]['message'] ?? 'Unknown error');
         }
         throw new Exception("Unknown error or unexpected response structure");
      } else {
         if (isset($body['errors']) && is_array($body['errors']) && count($body['errors']) > 0) {
            throw new Exception($body['errors'][0]['message'] ?? 'Unknown error');
         }
         throw new Exception("Errors node not set in server response");
      }
   }
}
