<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Airbnb Clone</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <section class="bg-gray-50 dark:bg-gray-800 min-h-screen flex items-center justify-center">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-white dark:bg-gray-700 px-4 pb-4 pt-4 sm:rounded-lg sm:px-10 sm:pb-6 sm:shadow">
                <?php if (isset($error)): ?>
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                        <?php echo htmlspecialchars($error); ?>
                    </div>
                <?php endif; ?>

                <h1 class="text-3xl font-extrabold text-center text-gray-900 dark:text-white mb-6">
                    Connexion
                </h1>

                <form method="POST" action="/login" class="space-y-6">
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-white">
                            Email
                        </label>
                        <input type="email" name="email" id="email" required 
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 dark:text-white">
                            Mot de passe
                        </label>
                        <input type="password" name="password" id="password" required 
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>

                    <div>
                        <button type="submit" 
                                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                            Se connecter
                        </button>
                    </div>
                </form>

                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Pas encore de compte ?
                        <a href="/register" class="font-medium text-indigo-600 hover:text-indigo-500">
                            S'inscrire
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </section>
</body>
</html>

