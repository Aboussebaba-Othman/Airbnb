<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Tableau de Bord Propriétaire</title>
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-100">
<!-- Barre de navigation -->
<nav class="bg-white shadow-md">
    <div class="container mx-auto px-4 py-2 flex justify-between items-center">
        <h1 class="text-xl font-bold text-red-600">Tableau de Bord Propriétaire</h1>
        <div class="flex items-center space-x-4">
            <span class="text-gray-700">Bienvenue</span>
            <img src="https://via.placeholder.com/40" alt="Profil" class="rounded-full">
            <a href="/logout" class="text-red-600 hover:text-red-800">Déconnexion</a>
        </div>
    </div>
</nav>

<!-- Contenu principal -->
<div class="container mx-auto px-4 py-8">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Carte : Statistiques des réservations -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-lg font-semibold text-gray-800">Réservations</h2>
            <p class="text-3xl font-bold text-red-600"><?= $reservationsThisMonth ?></p>
            <p class="text-gray-600">Réservations ce mois-ci</p>
            <canvas id="reservationChart" class="mt-4"></canvas>
        </div>

        <!-- Carte : Revenus -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-lg font-semibold text-gray-800">Revenus</h2>
            <p class="text-3xl font-bold text-green-600">€<?= number_format($revenueThisMonth, 2) ?></p>
            <p class="text-gray-600">Revenus ce mois-ci</p>
        </div>

        <!-- Carte : Taux d'occupation -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-lg font-semibold text-gray-800">Taux d'occupation</h2>
            <p class="text-3xl font-bold text-purple-600"><?= number_format($occupancyRateThisMonth, 2) ?>%</p>
            <p class="text-gray-600">Pourcentage de réservations</p>
        </div>
    </div>

    <!-- Section : Gestion des logements -->
    <div class="mt-8 bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Mes Annonces</h2>
        <div class="flex justify-between items-center mb-4">
            <button class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                <a href="/property/create">Ajouter une annonce</a>
            </button>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b">Titre</th>
                        <th class="py-2 px-4 border-b">Prix/nuit</th>
                        <th class="py-2 px-4 border-b">Catégorie</th>
                        <th class="py-2 px-4 border-b">Disponibilité</th>
                        <th class="py-2 px-4 border-b">Statut Validation</th>
                        <th class="py-2 px-4 border-b">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($annonces) && is_array($annonces)): ?>
                        <?php foreach ($annonces as $annonce): ?>
                            <tr>
                                <td class="py-2 px-4 border-b"><?= htmlspecialchars($annonce['title']) ?></td>
                                <td class="py-2 px-4 border-b"><?= htmlspecialchars($annonce['prix']) ?> €</td>
                                <td class="py-2 px-4 border-b"><?= htmlspecialchars($annonce['categorie']) ?></td>
                                <td class="py-2 px-4 border-b">
                                    <span class="bg-<?= $annonce['disponibilites'] === 'louer' ? 'green' : 'red' ?>-100 text-<?= $annonce['disponibilites'] === 'louer' ? 'green' : 'red' ?>-800 px-2 py-1 rounded">
                                        <?= htmlspecialchars($annonce['disponibilites']) ?>
                                    </span>
                                </td>
                                <td class="py-2 px-4 border-b">
                                    <span class="bg-<?= $annonce['validate'] === 'valider' ? 'blue' : 'yellow' ?>-100 text-<?= $annonce['validate'] === 'valider' ? 'blue' : 'yellow' ?>-800 px-2 py-1 rounded">
                                        <?= htmlspecialchars($annonce['validate']) ?>
                                    </span>
                                </td>
                                <td class="py-2 px-4 border-b">
                                    <a href="/property/edit/<?= $annonce['id'] ?>" class="bg-blue-500 text-white px-3 py-1 rounded">Modifier</a>
                                    <a href="/property/delete/<?= $annonce['id'] ?>" class="bg-red-500 text-white px-3 py-1 rounded">Supprimer</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>Aucune annonce trouvée.</p>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Section : Messagerie -->
    <div class="mt-8 bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Messagerie</h2>
        <div class="space-y-4">
            <div class="flex items-center space-x-4">
                <img src="https://via.placeholder.com/40" alt="Profil" class="rounded-full">
                <div>
                    <p class="font-semibold">Jean Dupont</p>
                    <p class="text-gray-600">Bonjour, je suis intéressé par votre logement...</p>
                </div>
                <button class="ml-auto bg-red-500 text-white px-3 py-1 rounded">Répondre</button>
            </div>
            <!-- Ajouter plus de messages ici -->
        </div>
    </div>
</div>

<!-- Script pour les graphiques -->
<script>
    const ctx = document.getElementById('reservationChart').getContext('2d');
    const reservationChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin'],
            datasets: [{
                label: 'Réservations',
                data: [5, 10, 8, 12, 15, 20],
                borderColor: '#FF0000',
                tension: 0.1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
</body>
</html>
