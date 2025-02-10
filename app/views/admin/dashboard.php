<?php
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <div class="min-h-screen bg-gray-100">
        <nav class="bg-white shadow-lg">
            <div class="max-w-7xl mx-auto px-4">
                <div class="flex justify-between items-center py-4">
                    <h1 class="text-xl font-semibold">Dashboard Admin</h1>
                    <div>
                        <span class="mr-4">Bienvenue <?php echo $_SESSION['username']; ?></span>
                        <a href="/logout" class="text-red-600 hover:text-red-800">Déconnexion</a>
                    </div>
                </div>
            </div>
        </nav>

        <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            <div class="px-4 py-6 sm:px-0">
                <div class="border-4 border-dashed border-gray-200 rounded-lg h-96">
                    <div class="p-4">
                        <h2 class="text-lg font-semibold mb-4">Statistiques</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>