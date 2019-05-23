<?php

use Slim\Http;

require 'vendor/autoload.php';

/**
 * This is how you would normally bootstrap your Slim application
 * For the sake of demonstration, we also add a simple middleware
 * to check that the entire app stack is being setup and executed
 * properly.
 */
$app = new \Slim\App();
$app->any('/test/{random}', function (Http\Request $request, Http\Response $response, array $args) {
    $data = [
        'args' => $args,
        'body' => (string) $request->getBody(),
        'parsedBody' => $request->getParsedBody(),
        'params' => $request->getParams(),
        'headers' => $request->getHeaders(),
        'uploadedFiles' => $request->getUploadedFiles()
    ];

    return $response->withJson($data);
});
