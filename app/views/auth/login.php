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
        <header class="w-full bg-white border-b border-gray-200 px-4 py-4">
            <div class="max-w-screen-xl mx-auto">
                <svg viewBox="0 0 32 32" class="h-8 w-8 text-airbnb">
                    <path d="M16 1c2.008 0 3.463.963 4.751 3.269l.533 1.025c1.954 3.83 6.114 12.54 7.1 14.836l.145.353c.667 1.591.91 2.472.91 3.494 0 4.424-3.33 8.023-7.439 8.023-2.206 0-4.375-1.177-6-3.257-1.625 2.08-3.794 3.257-6 3.257-4.109 0-7.439-3.599-7.439-8.023 0-1.022.243-1.903.91-3.494l.145-.353c.986-2.297 5.146-11.007 7.1-14.836l.533-1.025C12.537 1.963 13.992 1 16 1zm0 2c-1.239 0-2.053.539-2.987 2.21l-.523 1.008c-1.926 3.776-6.06 12.43-7.031 14.692l-.345.836c-.427 1.071-.573 1.655-.573 2.292 0 3.575 2.706 6.484 6.011 6.484 1.742 0 3.456-.853 4.748-2.618l.7-.914.7.914c1.292 1.765 3.006 2.618 4.748 2.618 3.305 0 6.011-2.909 6.011-6.484 0-.637-.146-1.221-.573-2.292l-.345-.836c-.97-2.263-5.105-10.917-7.031-14.692l-.523-1.008C18.053 3.539 17.239 3 16 3z" 
                    fill="currentColor">
                    </path>
                </svg>
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
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700">
                                Mot de passe
                            </label>
                            <input type="password" name="password" id="password" required
                                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-airbnb focus:border-airbnb px-4 py-3">
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
                                <img class="h-5 w-5" src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google">
                                <span class="ml-2">Continuer avec Google</span>
                            </a>
                            <a href="/auth/facebook"
                                class="flex justify-center items-center px-4 py-3 border border-gray-300 rounded-lg shadow-sm bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                                <img class="h-5 w-5" src="https://www.svgrepo.com/show/475647/facebook-color.svg" alt="Facebook">
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