<?php
/**
* This file hold all routes definitions.
*
* PHP version 7
*/

$routes = [
  'User' => [ // Controller
    ['index', '/', 'GET'], // action, url, method
    ['fetchAllUsers','/users','GET'],
    ['addUser','/user/add','POST'],
    ['editUser','/user/{id:\d+}','POST'],
    ['delUser','/user/{id:\d+}','GET'],
    ['search', '/find/{search:.+}', 'GET'],
   
  ]
];
