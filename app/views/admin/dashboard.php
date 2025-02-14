<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord - Airbnb Clone</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
    body {
        background: linear-gradient(135deg, #f8fafc, #e0f2fe);
    }

    .sidebar {
        background: linear-gradient(135deg, #ff5a5f, #ff385c);
    }

    .card {
        transition: all 0.3s ease;
    }

    .card:hover {
        transform: translateY(-5px);
    }

    .stats-card {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
    }
    </style>
</head>

<body class="flex h-screen overflow-hidden">
    <div class="w-72 sidebar text-white shadow-2xl">
        <div class="p-6 border-b border-white/20 flex items-center">
            <i class="fas fa-home text-2xl mr-3"></i>
            <h1 class="text-3xl font-bold tracking-wider">Airbnb</h1>
        </div>

        <nav class="mt-10 space-y-2 px-4">
            <a href="#" class="flex items-center space-x-3 py-3 px-4 rounded-lg bg-white/10 transition">
                <i class="fas fa-home w-6"></i>
                <span>Tableau de bord</span>
            </a>
            <a href="/admin/validation"
                class="flex items-center space-x-3 py-3 px-4 rounded-lg hover:bg-white/10 transition">
                <i class="fas fa-check-circle w-6"></i>
                <span>Validation Annonces</span>
            </a>
            <a href="/admin/users"
                class="flex items-center space-x-3 py-3 px-4 rounded-lg hover:bg-white/10 transition">
                <i class="fas fa-users w-6"></i>
                <span>Utilisateurs</span>
            </a>
            <a href="#" class="flex items-center space-x-3 py-3 px-4 rounded-lg hover:bg-white/10 transition">
                <i class="fas fa-calendar w-6"></i>
                <span>Réservations</span>
            </a>
            <a href="#" class="flex items-center space-x-3 py-3 px-4 rounded-lg hover:bg-white/10 transition">
                <i class="fas fa-cog w-6"></i>
                <span>Paramètres</span>
            </a>
            <div class="my-4 border-t border-white/10"></div>
            <a href="/logout"
                class="flex items-center space-x-3 py-3 px-4 rounded-lg bg-red-500/20 hover:bg-red-500/30 text-red-300 hover:text-red-200 transition-all duration-300">
                <i class="fas fa-sign-out-alt w-6"></i>
                <span class="font-medium">Déconnexion</span>
            </a>
        </nav>
    </div>

    <div class="flex-1 flex flex-col overflow-hidden">
        <header
            class="bg-white shadow-md border-b border-gray-100 px-6 py-4 flex justify-between items-center sticky top-0 z-40">
            <div class="flex items-center">
                <h2 class="text-3xl font-extrabold text-gray-800">Tableau de Bord</h2>
                <span class="ml-4 px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm">En ligne</span>
            </div>
            <div class="flex items-center space-x-6">
                <button class="p-2 hover:bg-gray-100 rounded-full">
                    <i class="fas fa-bell text-gray-600"></i>
                </button>
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 rounded-full ring-2 ring-primary ring-offset-2 overflow-hidden">
                        <img src="/api/placeholder/48/48" alt="User Avatar" class="w-full h-full object-cover" />
                    </div>
                    <div>
                        <span
                            class="text-gray-800 font-semibold text-base block"><?php echo $_SESSION['username']; ?></span>
                        <span class="text-gray-500 text-xs">Administrateur</span>
                    </div>
                </div>
            </div>
        </header>

        <main class="flex-1 overflow-x-hidden overflow-y-auto p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <div class="stats-card rounded-xl shadow-lg p-6 card">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm">Réservations</p>
                            <h3 class="text-2xl font-bold text-gray-800"><?php echo $stats['reservations_count']; ?>
                            </h3>
                        </div>
                        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-calendar text-blue-500 text-xl"></i>
                        </div>
                    </div>
                </div>

                <div class="stats-card rounded-xl shadow-lg p-6 card">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm">Revenus</p>
                            <h3 class="text-2xl font-bold text-gray-800">
                                <?php echo number_format($stats['total_revenue'], 2); ?> €</h3>
                        </div>
                        <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-euro-sign text-green-500 text-xl"></i>
                        </div>
                    </div>
                </div>

                <div class="stats-card rounded-xl shadow-lg p-6 card">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm">Utilisateurs</p>
                            <h3 class="text-2xl font-bold text-gray-800">
                                <?php echo isset($stats['total_users']) ? $stats['total_users'] : 0; ?>
                            </h3>
                            <p class="text-green-500 text-sm mt-2">
                                <i class="fas fa-users mr-1"></i> Total
                            </p>
                        </div>
                        <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-users text-purple-500 text-xl"></i>
                        </div>
                    </div>
                </div>

                <div class="stats-card rounded-xl shadow-lg p-6 card">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm">Avis</p>
                            <h3 class="text-2xl font-bold text-gray-800">
                                <?php echo isset($stats['avg_rating']) ? $stats['avg_rating'] : '0'; ?>/5
                            </h3>
                            <p class="text-yellow-500 text-sm mt-2">
                                <i class="fas fa-star mr-1"></i>
                                <?php echo isset($stats['new_reviews']) ? $stats['new_reviews'] : 0; ?> nouveaux
                            </p>
                        </div>
                        <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-star text-yellow-500 text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">Annonces Récentes</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php foreach ($annonces as $annonce): ?>
                    <div class="rounded-xl overflow-hidden shadow-md card">
                        <img src="<?php echo $annonce['photo'] ?? '/api/placeholder/400/200'; ?>"
                            alt="<?php echo htmlspecialchars($annonce['title']); ?>" class="w-full h-48 object-cover" />
                        <div class="p-4">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800">
                                        <?php echo htmlspecialchars($annonce['title']); ?>
                                    </h3>
                                    <p class="text-gray-600"><?php echo htmlspecialchars($annonce['categorie']); ?></p>
                                </div>
                                <span class="bg-<?php echo $annonce['validate'] === 'valider' ? 'green' : 'yellow'; ?>-100 
                                     text-<?php echo $annonce['validate'] === 'valider' ? 'green' : 'yellow'; ?>-800 
                                     px-2 py-1 rounded-full text-sm">
                                    <?php echo $annonce['validate']; ?>
                                </span>
                            </div>
                            <div class="mt-4 flex justify-between items-center">
                                <p class="text-gray-800 font-bold"><?php echo number_format($annonce['prix'], 2); ?> € /
                                    nuit</p>
                                <div class="flex items-center">
                                    <i class="fas fa-star text-yellow-400 mr-1"></i>
                                    <span
                                        class="text-gray-600"><?php echo number_format($annonce['rating'] ?? 0, 1); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </main>
    </div>
</body>

</html>