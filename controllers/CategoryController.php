<?php
require_once '../models/Category.php';

class CategoryController {
    private $categoryModel;

    public function __construct($pdo) {
        $this->categoryModel = new Category($pdo);
    }

    public function add() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'];
            $description = $_POST['description'];

            $this->categoryModel->create($name, $description);
            header('Location: /categories/list');
        }

        include '../views/category/add.php';
    }

    public function list() {
        $categories = $this->categoryModel->getAll();
        include '../views/category/list.php';
    }

    public function edit($id) {
        $category = $this->categoryModel->getById($id);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'];
            $description = $_POST['description'];

            $this->categoryModel->update($id, $name, $description);
            header('Location: /categories/list');
        }

        include '../views/category/edit.php';
    }

    public function delete($id) {
        $this->categoryModel->delete($id);
        header('Location: /categories/list');
    }
}
