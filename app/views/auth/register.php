<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - Airbnb</title>
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
                    <path
                        d="M16 1c2.008 0 3.463.963 4.751 3.269l.533 1.025c1.954 3.83 6.114 12.54 7.1 14.836l.145.353c.667 1.591.91 2.472.91 3.494 0 4.424-3.33 8.023-7.439 8.023-2.206 0-4.375-1.177-6-3.257-1.625 2.08-3.794 3.257-6 3.257-4.109 0-7.439-3.599-7.439-8.023 0-1.022.243-1.903.91-3.494l.145-.353c.986-2.297 5.146-11.007 7.1-14.836l.533-1.025C12.537 1.963 13.992 1 16 1zm0 2c-1.239 0-2.053.539-2.987 2.21l-.523 1.008c-1.926 3.776-6.06 12.43-7.031 14.692l-.345.836c-.427 1.071-.573 1.655-.573 2.292 0 3.575 2.706 6.484 6.011 6.484 1.742 0 3.456-.853 4.748-2.618l.7-.914.7.914c1.292 1.765 3.006 2.618 4.748 2.618 3.305 0 6.011-2.909 6.011-6.484 0-.637-.146-1.221-.573-2.292l-.345-.836c-.97-2.263-5.105-10.917-7.031-14.692l-.523-1.008C18.053 3.539 17.239 3 16 3z"
                        fill="currentColor"></path>
                </svg>
            </div>
        </header>

        <main class="flex-grow flex items-center justify-center px-4 py-12 sm:px-6 lg:px-8">
            <div class="max-w-md w-full">
                <div class="text-center mb-6">
                    <h2 class="text-2xl font-semibold text-gray-900">Créer un compte</h2>
                </div>

                <div class="bg-white py-8 px-4 shadow-lg rounded-lg sm:px-10">
                    <?php if ($this->session->getFlash('error')): ?>
                    <div class="mb-6 bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-lg">
                        <?php echo $this->session->getFlash('error'); ?>
                    </div>
                    <?php endif; ?>

                    <form method="POST" action="/register" enctype="multipart/form-data" class="space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nom d'utilisateur</label>
                            <input type="text" name="username"
                                value="<?php echo isset($old['username']) ? htmlspecialchars($old['username']) : ''; ?>"
                                class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:ring-airbnb focus:border-airbnb px-4 py-2">
                            <?php if (isset($errors['username'])): ?>
                            <p class="mt-1 text-sm text-red-600"><?php echo $errors['username']; ?></p>
                            <?php endif; ?>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" name="email"
                                value="<?php echo isset($old['email']) ? htmlspecialchars($old['email']) : ''; ?>"
                                class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:ring-airbnb focus:border-airbnb px-4 py-2">
                            <?php if (isset($errors['email'])): ?>
                            <p class="mt-1 text-sm text-red-600"><?php echo $errors['email']; ?></p>
                            <?php endif; ?>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Type de compte</label>
                            <div class="flex gap-4">
                                <div class="flex-1">
                                    <input type="radio" id="voyageur" name="role" value="voyageur"
                                        <?php echo (!isset($old['role']) || $old['role'] === 'voyageur') ? 'checked' : ''; ?>
                                        class="sr-only peer">
                                    <label for="voyageur"
                                        class="flex items-center justify-center p-3 text-gray-700 border rounded-md cursor-pointer hover:border-airbnb peer-checked:border-airbnb peer-checked:bg-red-50 peer-checked:text-airbnb">
                                        Voyageur
                                    </label>
                                </div>
                                <div class="flex-1">
                                    <input type="radio" id="proprietaire" name="role" value="proprietaire"
                                        <?php echo (isset($old['role']) && $old['role'] === 'proprietaire') ? 'checked' : ''; ?>
                                        class="sr-only peer">
                                    <label for="proprietaire"
                                        class="flex items-center justify-center p-3 text-gray-700 border rounded-md cursor-pointer hover:border-airbnb peer-checked:border-airbnb peer-checked:bg-red-50 peer-checked:text-airbnb">
                                        Propriétaire
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Photo de profil</label>
                            <div class="flex items-center">
                                <div id="preview"
                                    class="w-12 h-12 rounded-full bg-gray-100 flex items-center justify-center mr-4">
                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <input type="file" name="photo" accept="image/*"
                                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-airbnb file:text-white hover:file:bg-airbnb-dark"
                                    onchange="previewImage(this)">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Description (optionnelle)</label>
                            <textarea name="description" rows="3"
                                class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:ring-airbnb focus:border-airbnb px-4 py-2"><?php echo isset($old['description']) ? htmlspecialchars($old['description']) : ''; ?></textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Mot de passe</label>
                            <input type="password" name="password"
                                class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:ring-airbnb focus:border-airbnb px-4 py-2">
                            <?php if (isset($errors['password'])): ?>
                            <p class="mt-1 text-sm text-red-600"><?php echo $errors['password']; ?></p>
                            <?php endif; ?>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Confirmer le mot de passe</label>
                            <input type="password" name="password_confirm"
                                class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:ring-airbnb focus:border-airbnb px-4 py-2">
                        </div>

                        <button type="submit"
                            class="w-full py-2 px-4 border border-transparent rounded-md shadow-sm text-white bg-airbnb hover:bg-airbnb-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-airbnb">
                            S'inscrire
                        </button>
                    </form>

                    <div class="mt-6 text-center">
                        <p class="text-sm text-gray-600">
                            Déjà un compte ?
                            <a href="/login" class="font-medium text-airbnb hover:text-airbnb-dark">Se connecter</a>
                        </p>
                    </div>

                    <div class="mt-6">
                        <div class="relative">
                            <div class="absolute inset-0 flex items-center">
                                <div class="w-full border-t border-gray-300"></div>
                            </div>
                            <div class="relative flex justify-center text-sm">
                                <span class="px-2 bg-white text-gray-500">ou</span>
                            </div>
                        </div>

                        <div class="mt-6 grid grid-cols-2 gap-3">
                            <a href="/auth/google"
                                class="flex justify-center items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                <img class="h-5 w-5" src="https://www.svgrepo.com/show/475656/google-color.svg"
                                    alt="Google">
                                <span class="ml-2">Google</span>
                            </a>
                            <a href="/auth/facebook"
                                class="flex justify-center items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                <img class="h-5 w-5" src="https://www.svgrepo.com/show/475647/facebook-color.svg"
                                    alt="Facebook">
                                <span class="ml-2">Facebook</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('preview');
                preview.innerHTML = `<img src="${e.target.result}" class="w-12 h-12 rounded-full object-cover">`;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    </script>
</body>

</html>