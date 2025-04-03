<?php
require_once '../config/db_connection.php';
require_once '../models/Product.php';
require_once '../models/Category.php';
require_once '../models/Material.php';

class ProductController {
    private $productModel;
    private $categoryModel;
    private $materialModel;

    public function __construct($pdo) {
        $this->productModel = new Product($pdo);
        $this->categoryModel = new Category($pdo);
        $this->materialModel = new Material($pdo);
    }

    public function add() {
        $categories = $this->categoryModel->getAll();
        $materials = $this->materialModel->getAll();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Logique de soumission du formulaire
            $title = $_POST['title'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $category_id = $_POST['category_id'];
            $status = $_POST['status'];
            $material_ids = $_POST['material_ids'];

            $this->productModel->create($title, $description, $price, $category_id, $status, $material_ids);
            header('Location: /products/list');
        }

        include '../views/product/add.php'; // Affiche le formulaire d'ajout
    }

    public function list() {
        $products = $this->productModel->getAll();
        include '../views/product/list.php'; // Affiche la liste des produits
    }

    public function edit($id) {
        $product = $this->productModel->getById($id);
        $categories = $this->categoryModel->getAll();
        $materials = $this->materialModel->getAll();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Logique de mise à jour du produit
            $title = $_POST['title'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $category_id = $_POST['category_id'];
            $status = $_POST['status'];
            $material_ids = $_POST['material_ids'];

            $this->productModel->update($id, $title, $description, $price, $category_id, $status, $material_ids);
            header('Location: /products/list');
        }

        include '../views/product/edit.php'; // Affiche le formulaire d'édition
    }

    public function delete($id) {
        $this->productModel->delete($id);
        header('Location: /products/list');
    }
}
