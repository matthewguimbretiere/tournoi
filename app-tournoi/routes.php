<?php

$route->addRoute('GET', '/login', 'BackOfficeController@login');
// == Front - Classement (inscription) ========================
$route->addRoute('GET', '/', 'FrontController@index');
$route->addRoute('POST', '/new-user', 'FrontController@newUser');
// == Front - Authentification ================================
$route->addRoute('POST', '/login-check', 'BackOfficeController@loginCheck');
$route->addRoute('GET', '/delog', 'BackOfficeController@delog');
// == Backoffice - Liste joueurs ==============================
$route->addRoute('GET', '/backoffice/liste-joueurs', 'BackOfficeController@listeJoueurs');
$route->addRoute('GET', '/backoffice/new-joueur', 'BackOfficeController@newJoueur');
$route->addRoute('POST', '/backoffice/save-joueur', 'BackOfficeController@saveJoueur');
$route->addRoute('GET', '/backoffice/edit-joueur/{idJoueurs:[0-9]+}/{idParties:[0-9]+}', 'BackOfficeController@editJoueur');
$route->addRoute('GET', '/backoffice/delete-joueur/{id:[0-9]+}', 'BackOfficeController@deleteJoueur');
$route->addRoute(['GET', 'POST'], '/backoffice/update-joueur/{idJoueurs:[0-9]+}/{idParties:[0-9]+}', 'BackOfficeController@updateJoueur');


$route->addRoute('GET', '/{date}', 'FrontController@indexDate');
$route->addRoute('GET', '/backoffice/liste-joueurs/{date}', 'BackOfficeController@listeJoueursDates');



?>