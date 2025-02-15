<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier une annonce</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-4">Modifier une annonce</h1>
        <form action="/property/update/<?= $annonce['id'] ?>" method="POST" class="bg-white p-6 rounded-lg shadow-md">
            <div class="mb-4">
                <label class="block text-gray-700">Titre</label>
                <input type="text" name="title" value="<?= htmlspecialchars($annonce['title']) ?>" class="w-full px-3 py-2 border rounded-lg">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Description</label>
                <textarea name="description" class="w-full px-3 py-2 border rounded-lg"><?= htmlspecialchars($annonce['description']) ?></textarea>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Prix par nuit</label>
                <input type="number" name="prix" value="<?= htmlspecialchars($annonce['prix']) ?>" class="w-full px-3 py-2 border rounded-lg">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Catégorie</label>
                <select name="categorie" class="w-full px-3 py-2 border rounded-lg">
                    <option value="Appartement" <?= $annonce['categorie'] === 'Appartement' ? 'selected' : '' ?>>Appartement</option>
                    <option value="Maison" <?= $annonce['categorie'] === 'Maison' ? 'selected' : '' ?>>Maison</option>
                    <option value="Villa" <?= $annonce['categorie'] === 'Villa' ? 'selected' : '' ?>>Villa</option>
                    <option value="Cabane" <?= $annonce['categorie'] === 'Cabane' ? 'selected' : '' ?>>Cabane</option>
                </select>
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Mettre à jour</button>
        </form>
    </div>
</body>
</html>