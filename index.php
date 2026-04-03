<?php

// $page = $_GET['page'] ?? 'login';

// switch ($page) {
//     case 'login':
//         require __DIR__ . '/app/controllers/LoginController.php';
        
//         break;
//     case 'register':
//         require __DIR__ . '/app/controllers/RegisterController.php';
        
//         break;
//     case 'recordlist':
//         require __DIR__ . '/app/controllers/RecordListController.php';
        
//         break;
//     case 'addrecord':
//         require __DIR__ . '/app/controllers/AddRecordController.php';
            
//         break;
//     default:
//         http_response_code(404);
//         echo '404 Not Found';
// }

$routes = [
    'login' => '/app/controllers/LoginController.php',
    'register' => '/app/controllers/RegisterController.php',
    'recordlist' => '/app/controllers/RecordListController.php',
    'addrecord' => '/app/controllers/AddRecordController.php',
    'editrecord' => '/app/controllers/EditRecordController.php',
    'bandlist' => '/app/controllers/BandListController.php',
    'addband' => '/app/controllers/AddBandController.php'
];

$page = $_GET['page'] ?? 'login';

if (array_key_exists($page, $routes)) {
    require __DIR__ . $routes[$page];
} else {
    http_response_code(404);
    echo '404 Not Found';
}
