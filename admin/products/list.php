<?php include '../includes/header.php'; ?>

<h2>Liste des produits</h2>

<table>
    <tr>
        <th>Titre</th>
        <th>Description</th>
        <th>Prix</th>
        <th>Catégorie</th>
        <th>Statut</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($products as $product) : ?>
        <tr>
            <td><?= $product['title']; ?></td>
            <td><?= $product['description']; ?></td>
            <td><?= $product['price']; ?></td>
            <td><?= $product['category']; ?></td>
            <td><?= $product['status']; ?></td>
            <td><a href="/product/edit/<?= $product['id']; ?>">Modifier</a></td>
        </tr>
    <?php endforeach; ?>
</table>

<?php include '../includes/footer.php'; ?>
