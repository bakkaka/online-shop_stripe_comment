<?php
require_once '../config/db_connection.php';
require_once '../controllers/ProductController.php';
require_once '../controllers/CategoryController.php';
require_once '../controllers/MaterialController.php';

$productController = new ProductController($pdo);

if ($_SERVER['REQUEST_URI'] == '/products/add') {
    $productController->add();
} elseif ($_SERVER['REQUEST_URI'] == '/products/list') {
    $productController->list();
}
