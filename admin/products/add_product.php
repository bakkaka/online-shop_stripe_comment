<?php include '../includes/header.php'; ?>

<h2>Ajouter un produit</h2>

<form method="POST">
    <label for="title">Titre :</label>
    <input type="text" name="title" required><br>

    <label for="description">Description :</label>
    <textarea name="description" required></textarea><br>

    <label for="price">Prix :</label>
    <input type="number" name="price" step="0.01" required><br>

    <label for="category_id">Catégorie :</label>
    <select name="category_id" required>
        <?php foreach ($categories as $category) : ?>
            <option value="<?= $category['id']; ?>"><?= $category['name']; ?></option>
        <?php endforeach; ?>
    </select><br>

    <label for="status">Statut :</label>
    <input type="radio" name="status" value="published" required> Publié
    <input type="radio" name="status" value="pending"> En attente<br>

    <label for="material_ids">Matériaux :</label>
    <select name="material_ids[]" multiple required>
        <?php foreach ($materials as $material) : ?>
            <option value="<?= $material['id']; ?>"><?= $material['name']; ?></option>
        <?php endforeach; ?>
    </select><br>

    <input type="submit" value="Ajouter le produit">
</form>

<?php include '../includes/footer.php'; ?>
