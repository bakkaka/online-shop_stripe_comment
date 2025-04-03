<?php
require_once '../models/Material.php';

class MaterialController {
    private $materialModel;

    public function __construct($pdo) {
        $this->materialModel = new Material($pdo);
    }

    public function add() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'];
            $description = $_POST['description'];

            $this->materialModel->create($name, $description);
            header('Location: /materials/list');
        }

        include '../views/material/add.php';
    }

    public function list() {
        $materials = $this->materialModel->getAll();
        include '../views/material/list.php';
    }

    public function edit($id) {
        $material = $this->materialModel->getById($id);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'];
            $description = $_POST['description'];

            $this->materialModel->update($id, $name, $description);
            header('Location: /materials/list');
        }

        include '../views/material/edit.php';
    }

    public function delete($id) {
        $this->materialModel->delete($id);
        header('Location: /materials/list');
    }
}
