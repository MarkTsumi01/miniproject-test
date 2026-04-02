<?php

$page = $_GET['page'] ?? 'login';

switch ($page) {
    case 'login':
        require __DIR__ . '/app/controllers/LoginController.php';
        
        break;
    case 'register':
        require __DIR__ . '/app/controllers/RegisterController.php';
        
        break;
    case 'recordlist':
        require __DIR__ . '/app/controllers/RecordListController.php';
        
        break;
    case 'addrecord':
        require __DIR__ . '/app/controllers/AddRecordController.php';
            
        break;
    default:
        http_response_code(404);
        echo '404 Not Found';
}


// <?php
// $routes = [
//     'login'      => '/controllers/LoginController.php',
//     'register'   => '/controllers/RegisterController.php',
//     'recordlist' => '/controllers/RecordController.php',
// ];

// $page = $_GET['page'] ?? 'login';

// if (array_key_exists($page, $routes)) {
//     include __DIR__ . $routes[$page];
// } else {
//     http_response_code(404);
//     echo '404 Not Found';
// }