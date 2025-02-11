<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?> - Airbnb Clone</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <nav class="bg-white shadow-lg">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <div>
                    <a href="/" class="text-2xl font-bold text-red-500">Airbnb Clone</a>
                </div>
                <div class="flex items-center space-x-4">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <a href="/logout" class="text-gray-600 hover:text-gray-900">Déconnexion</a>
                    <?php else: ?>
                        <a href="/login" class="text-gray-600 hover:text-gray-900">Connexion</a>
                        <a href="/register" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600">
                            S'inscrire
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-6xl mx-auto mt-8 px-4">
        <section class="text-center">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">
                Bienvenue sur notre clone Airbnb
            </h1>
            <p class="text-xl text-gray-600 mb-8">
                Trouvez des logements uniques et vivez des expériences authentiques
            </p>

            <?php if (!isset($_SESSION['user_id'])): ?>
                <div class="space-x-4">
                    <a href="/login" class="inline-block bg-red-500 text-white px-6 py-3 rounded-md hover:bg-red-600">
                        Commencer
                    </a>
                </div>
            <?php endif; ?>
        </section>
    </main>
</body>
</html>