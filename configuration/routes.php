<?php

declare(strict_types=1);

// User Routes
global $app;

// Add the routes here like in the following example:
$app->post('/user', \Source\User\Application\Controller\CreateAUserController::class);
//$app->delete('/example/{ExampleId}', DeleteAnExampleController::class);
//$app->put('/example/{exampleId}', UpdateAnExampleController::class);
//$app->get('/example/criteria/the-criteria', FindAnExampleByCriteriaController::class);
