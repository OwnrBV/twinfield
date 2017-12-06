<?php

namespace PhpTwinfield\ApiConnectors;

use PhpTwinfield\Exception;
use PhpTwinfield\Response\Response;
use PhpTwinfield\Secure\Config;
use PhpTwinfield\Secure\Login;
use PhpTwinfield\Secure\Service;
use PhpTwinfield\Secure\SoapClient;

/**
 * All Factories used by all components extend this factory for common shared methods that help normalize the usage
 * between different components.
 *
 * @author Leon Rowland <leon@rowland.nl>
 */
abstract class BaseApiConnector
{
    /**
     * @var SoapClient
     */
    private $client;

    /**
     * @param Login $login
     */
    public function __construct(Login $login)
    {
        $this->client = $login->getClient();
    }

    /**
     * Send a DOMDocument to the Twinfield service.
     *
     * A document can be both an object for storage or a search / retrieval request.
     *
     * If there is an error, an exception is thrown.
     *
     * @param \DOMDocument $DOMDocument
     * @return Response
     * @throws Exception
     */
    protected function sendDocument(\DOMDocument $DOMDocument): Response
    {
        // Send the DOM document request and set the response
        $response = $this->client->send($DOMDocument);

        if (!$response->isSuccessful()) {
            throw new Exception(implode(", ", $response->getErrorMessages()));
        }

        return $response;
    }
}