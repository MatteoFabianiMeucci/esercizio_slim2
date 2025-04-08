<?php
use Slim\Factory\AppFactory;

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/controllers/AlunniController.php';
require __DIR__ . '/controllers/CertificazioniController.php';

$app = AppFactory::create();

$app->get('/alunni', "AlunniController:index");

$app->get('/alunni/{id:\d+}', "AlunniController:show");

$app->get('/alunni/{surname}', "AlunniController:search");

$app->get('/alunni/sort/{column}:{order:\d{1}}', "AlunniController:showOrdered");

$app->post('/alunni', "AlunniController:create");

$app->put('/alunni/{id:\d+}', "AlunniController:update");

$app->delete('/alunni/{id:\d+}', "AlunniController:destroy");

//certificazioni

$app->get('/alunni/{id:\d+}/cert', "CertificazioniController:index");

$app->get('/alunni/{id:\d+}/cert/{id_cert:\d+}', "CertificazioniController:show");

$app->post('/alunni/{id:\d+}/cert', "CertificazioniController:create");

$app->put('/alunni/{id:\d+}/cert/{id_cert:\d+}', "CertificazioniController:update");

$app->delete('/alunni/{id:\d+}/cert/{id_cert:\d+}', "CertificazioniController:destroy");

$app->run();
?>