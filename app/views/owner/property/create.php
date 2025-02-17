<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer une annonce</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-4">Créer une annonce</h1>
    <!-- Ajoutez enctype pour gérer les fichiers -->
    <form action="/property/store" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow-md">
        <!-- Titre -->
        <div class="mb-4">
            <label class="block text-gray-700">Titre</label>
            <input type="text" name="title" required class="w-full px-3 py-2 border rounded-lg">
        </div>

        <!-- Photo -->
        <div class="mb-4">
            <label class="block text-gray-700">Photo</label>
            <input type="file" name="photo" accept="image/*" class="w-full px-3 py-2 border rounded-lg">
        </div>

        <!-- Prix -->
        <div class="mb-4">
            <label class="block text-gray-700">Prix par nuit (€)</label>
            <input type="number" step="0.01" name="prix" required class="w-full px-3 py-2 border rounded-lg">
        </div>

        <!-- Équipements (JSON) -->
        <div class="mb-4">
            <label class="block text-gray-700">Équipements </label>
            <textarea name="equipements" class="w-full px-3 py-2 border rounded-lg" 
                    placeholder='["WiFi", "Cuisine", "TV"]'></textarea>
        </div>

        <!-- Description -->
        <div class="mb-4">
            <label class="block text-gray-700">Description</label>
            <textarea name="description" required class="w-full px-3 py-2 border rounded-lg"></textarea>
        </div>

        <!-- Catégorie -->
        <div class="mb-4">
            <label class="block text-gray-700">Catégorie</label>
            <select name="categorie" class="w-full px-3 py-2 border rounded-lg">
                <option value="Appartement">Appartement</option>
                <option value="Maison">Maison</option>
                <option value="Villa">Villa</option>
                <option value="Cabane">Cabane</option>
            </select>
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Créer</button>
    </form>
    </div>
</body>
</html>