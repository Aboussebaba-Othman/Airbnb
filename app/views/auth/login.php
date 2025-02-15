<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Airbnb</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    'airbnb': '#FF385C',
                    'airbnb-dark': '#E31C5F',
                }
            }
        }
    }
    </script>
</head>

<body class="bg-gray-50">
    <div class="min-h-screen flex flex-col">
    <header class="sticky top-0 bg-white shadow-sm z-50">
    <div class="container mx-auto px-4 py-4">
      <div class="flex items-center justify-between">
        <a href="/" class="flex items-center space-x-2">
          <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/6/69/Airbnb_Logo_B%C3%A9lo.svg/800px-Airbnb_Logo_B%C3%A9lo.svg.png" alt="Logo Airbnb" class="h-8">
        </a>

        <div class="relative w-96">
          <input
            type="text"
            placeholder="Rechercher..."
            class="pl-10 pr-4 py-2 border rounded-full w-full focus:outline-none focus:ring-2 focus:ring-rose-500"
          />
          <svg class="absolute left-3 top-2.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 103.75 3.75a7.5 7.5 0 0012.9 12.9z"></path>
          </svg>
        </div>

        <div class="flex space-x-4">
          <a href="/register" class="bg-rose-500 text-white py-2 px-4 rounded-full hover:bg-rose-600 transition-colors">
            S'inscrire
          </a>
          <a href="/login" class="border border-rose-500 text-rose-500 py-2 px-4 rounded-full hover:bg-rose-50 transition-colors">
            Se connecter
          </a>
        </div>
      </div>
    </div>
  </header>

        <main class="flex-grow flex items-center justify-center px-4 py-12 sm:px-6 lg:px-8">
            <div class="max-w-md w-full">
                <div class="bg-white py-8 px-4 shadow-lg rounded-xl sm:px-10">
                    <h1 class="text-2xl font-semibold text-gray-900 text-center mb-8">
                        Connexion
                    </h1>

                    <form method="POST" action="/login" class="space-y-6">
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">
                                Email
                            </label>
                            <input type="email" name="email" id="email" required
                                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-airbnb focus:border-airbnb px-4 py-3">
                            <?php if (isset($errors['email'])): ?>
                            <span class="error"><?php echo $errors['email']; ?></span>
                            <?php endif; ?>
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700">
                                Mot de passe
                            </label>
                            <input type="password" name="password" id="password" required
                                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-airbnb focus:border-airbnb px-4 py-3">
                            <?php if (isset($errors['password'])): ?>
                            <span class="error"><?php echo $errors['password']; ?></span>
                            <?php endif; ?>
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <input type="checkbox" id="remember" name="remember"
                                    class="h-4 w-4 text-airbnb border-gray-300 rounded focus:ring-airbnb">
                                <label for="remember" class="ml-2 block text-sm text-gray-600">
                                    Se souvenir de moi
                                </label>
                            </div>
                            <div class="text-sm">
                                <a href="#" class="font-medium text-airbnb hover:text-airbnb-dark">
                                    Mot de passe oublié ?
                                </a>
                            </div>
                        </div>

                        <button type="submit"
                            class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-base font-medium text-white bg-airbnb hover:bg-airbnb-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-airbnb transition-colors duration-200">
                            Continuer
                        </button>
                    </form>

                    <div class="mt-6">
                        <div class="relative">
                            <div class="absolute inset-0 flex items-center">
                                <div class="w-full border-t border-gray-300"></div>
                            </div>
                            <div class="relative flex justify-center text-sm">
                                <span class="px-2 bg-white text-gray-500">ou</span>
                            </div>
                        </div>

                        <div class="mt-6 grid grid-cols-1 gap-3">
                            <a href="/auth/google"
                                class="flex justify-center items-center px-4 py-3 border border-gray-300 rounded-lg shadow-sm bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                                <img class="h-5 w-5" src="https://www.svgrepo.com/show/475656/google-color.svg"
                                    alt="Google">
                                <span class="ml-2">Continuer avec Google</span>
                            </a>
                            <a href="/auth/facebook"
                                class="flex justify-center items-center px-4 py-3 border border-gray-300 rounded-lg shadow-sm bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                                <img class="h-5 w-5" src="https://www.svgrepo.com/show/475647/facebook-color.svg"
                                    alt="Facebook">
                                <span class="ml-2">Continuer avec Facebook</span>
                            </a>
                        </div>
                    </div>

                    <div class="mt-6 text-center">
                        <p class="text-sm text-gray-600">
                            Pas encore sur Airbnb ?
                            <a href="/register" class="font-medium text-airbnb hover:text-airbnb-dark">
                                Inscription
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>

</html>