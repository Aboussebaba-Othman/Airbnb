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
                <!-- Dans app/views/auth/login.php -->
<div class="mt-6">
    <div class="relative">
        <div class="absolute inset-0 flex items-center">
            <div class="w-full border-t border-gray-300"></div>
        </div>
        <div class="relative flex justify-center text-sm">
            <span class="px-2 bg-white text-gray-500">Ou continuer avec</span>
        </div>
    </div>

    <div class="mt-6 grid grid-cols-2 gap-3">
        <a href="/auth/google" 
           class="flex justify-center items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
            <img class="h-5 w-5" src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google">
            <span class="ml-2">Google</span>
        </a>
        <a href="/auth/facebook"
           class="flex justify-center items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
            <img class="h-5 w-5" src="https://www.svgrepo.com/show/475647/facebook-color.svg" alt="Facebook">
            <span class="ml-2">Facebook</span>
        </a>
    </div>
</div>
            </div>
        </div>
    </section>
</body>
</html>

