<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use OpenApi\Attributes as OA;

#[OA\OpenApi(security: [['WebClientBearerJwt' => []]])]
#[OA\Server(
    url: 'https://api.dev.tolkevarav.eki.ee/classifier/api/v1', // FIXME: Confirm correct URL
    description: 'Development Server’s Classifier Service API Root'
)]
#[OA\Info(
    version: '0.0.1',
    title: 'Tõlkevärav Classifier Service API',
    contact: new OA\Contact(url: 'https://github.com/keeleinstituut/tv-classifier')
)]
#[OA\ExternalDocumentation(url: 'https://github.com/keeleinstituut/tv-tolkevarav/wiki')]
#[OA\SecurityScheme(
    securityScheme: 'WebClientBearerJwt',
    type: 'http',
    description: 'Bearer JWT signed by Tõlkevärav’s SSO for the web client',
    bearerFormat: 'JWT',
    scheme: 'bearer'
)]
class Controller extends BaseController
{
    use ValidatesRequests;
}
