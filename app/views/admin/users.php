<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Gestion des Utilisateurs</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
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
            <a href="/admin/dashboard" class="flex items-center space-x-3 py-3 px-4 rounded-lg bg-white/10 transition">
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
            <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">Gestion des Utilisateurs</h2>
                </div>

                <?php if ($this->session->getFlash('success')): ?>
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4">
                    <?php echo $this->session->getFlash('success'); ?>
                </div>
                <?php endif; ?>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    ID</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Photo</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Nom</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Email</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Rôle</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Statut</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php foreach ($users as $user): ?>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap"><?php echo $user['id']; ?></td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <img src="<?php echo $user['photo'] ? '/assets/uploads/profiles/' . $user['photo'] : '/api/placeholder/32/32'; ?>"
                                        alt="Profile" class="h-8 w-8 rounded-full">
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <?php echo htmlspecialchars($user['username']); ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($user['email']); ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
           <?php echo ($user['role_title'] ?? '') === 'admin' ? 'bg-purple-100 text-purple-800' : 
                     (($user['role_title'] ?? '') === 'proprietaire' ? 'bg-blue-100 text-blue-800' : 
                      'bg-green-100 text-green-800'); ?>">
                                        <?php echo htmlspecialchars($user['role_title'] ?? 'N/A'); ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
           <?php echo ($user['status'] ?? 'active') === 'blocked' ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800'; ?>">
                                        <?php echo ($user['status'] ?? 'active') === 'blocked' ? 'Bloqué' : 'Actif'; ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <?php if (($user['id'] ?? 0) != ($_SESSION['user_id'] ?? -1)): ?>
                                    <button onclick="toggleStatus(<?php echo $user['id']; ?>)"
                                        class="text-blue-600 hover:text-blue-900 mr-3"
                                        title="<?php echo ($user['status'] ?? 'active') === 'blocked' ? 'Débloquer' : 'Bloquer'; ?>">
                                        <i
                                            class="fas <?php echo ($user['status'] ?? 'active') === 'blocked' ? 'fa-lock-open' : 'fa-lock'; ?>"></i>
                                    </button>
                                    <button onclick="confirmDelete(<?php echo $user['id']; ?>)"
                                        class="text-red-600 hover:text-red-900" title="Supprimer">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <script>
            function confirmDelete(id) {
                if (confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')) {
                    window.location.href = `/admin/users/delete/${id}`;
                }
            }

            function toggleStatus(id) {
                window.location.href = `/admin/users/toggle-status/${id}`;
            }
            </script>
        </main>
    </div>
</body>