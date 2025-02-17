<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Éditer mon profil</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gray-50">

<?php
// Get flash messages
$successMessage = $this->session->getFlash('success');
$errorMessage = $this->session->getFlash('error');

// Determine which data to use (prioritize old data from validation)
$username = $old['username'] ?? $user['username'] ?? '';
$email = $old['email'] ?? $user['email'] ?? '';
$description = $old['description'] ?? $user['description'] ?? '';
?>

<div class="container mx-auto px-4 py-12">
    <div class="max-w-3xl mx-auto bg-white rounded-2xl shadow-xl p-8">
        <h1 class="text-3xl font-bold mb-6 text-gray-800">Éditer mon profil</h1>

        <?php if ($successMessage): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                <?= htmlspecialchars($successMessage) ?>
            </div>
        <?php endif; ?>

        <?php if ($errorMessage): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <?= htmlspecialchars($errorMessage) ?>
            </div>
        <?php endif; ?>

        <form action="/profile/edit" method="POST" enctype="multipart/form-data" class="space-y-6">
            <!-- Username -->
            <div>
                <label for="username" class="block text-gray-600 font-semibold mb-2">Nom d'utilisateur</label>
                <input 
                    type="text" 
                    id="username" 
                    name="username" 
                    value="<?= htmlspecialchars($username) ?>" 
                    class="w-full px-4 py-2 border <?= isset($errors['username']) ? 'border-red-500' : 'border-gray-300' ?> rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-500"
                    required
                >
                <?php if (isset($errors['username'])): ?>
                    <p class="text-red-500 text-sm mt-1"><?= htmlspecialchars($errors['username'][0]) ?></p>
                <?php endif; ?>
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-gray-600 font-semibold mb-2">Email</label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    value="<?= htmlspecialchars($email) ?>" 
                    class="w-full px-4 py-2 border <?= isset($errors['email']) ? 'border-red-500' : 'border-gray-300' ?> rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-500"
                    required
                >
                <?php if (isset($errors['email'])): ?>
                    <p class="text-red-500 text-sm mt-1"><?= htmlspecialchars($errors['email'][0]) ?></p>
                <?php endif; ?>
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-gray-600 font-semibold mb-2">Description</label>
                <textarea 
                    id="description" 
                    name="description" 
                    rows="4" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-500"
                ><?= htmlspecialchars($description) ?></textarea>
            </div>

            <div>
                <label for="photo" class="block text-gray-600 font-semibold mb-2">Photo de profil</label>
                <input 
                    type="file" 
                    id="photo" 
                    name="photo" 
                    accept="image/jpeg,image/png,image/jpg"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-500"
                >
                <p class="text-gray-500 text-sm mt-1">Fichiers autorisés : JPG, JPEG, PNG (max 5MB)</p>
            </div>

            <div class="flex justify-between items-center">
                <button 
                    type="submit" 
                    class="bg-rose-500 hover:bg-rose-600 text-white font-bold py-2 px-6 rounded-lg transition-colors"
                >
                    Mettre à jour le profil
                </button>
                <a 
                    href="" 
                    class="text-rose-500 hover:underline"
                >
                    Annuler
                </a>
            </div>
        </form>
    </div>
</div>

</body>
</html>
