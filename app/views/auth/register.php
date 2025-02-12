<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription - Airbnb Clone</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex flex-col justify-center py-12 sm:px-6 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                Créer un compte
            </h2>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
                <?php if ($this->session->getFlash('error')): ?>
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                        <?php echo $this->session->getFlash('error'); ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="/register" enctype="multipart/form-data" class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            Nom d'utilisateur
                        </label>
                        <input type="text" name="username" 
                               value="<?php echo isset($old['username']) ? htmlspecialchars($old['username']) : ''; ?>"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <?php if (isset($errors['username'])): ?>
                            <p class="mt-2 text-sm text-red-600"><?php echo $errors['username']; ?></p>
                        <?php endif; ?>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            Email
                        </label>
                        <input type="email" name="email" 
                               value="<?php echo isset($old['email']) ? htmlspecialchars($old['email']) : ''; ?>"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <?php if (isset($errors['email'])): ?>
                            <p class="mt-2 text-sm text-red-600"><?php echo $errors['email']; ?></p>
                        <?php endif; ?>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            Je suis un
                        </label>
                        <select name="role" 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="voyageur" <?php echo (isset($old['role']) && $old['role'] === 'voyageur') ? 'selected' : ''; ?>>
                                Voyageur
                            </option>
                            <option value="Propriétaire" <?php echo (isset($old['role']) && $old['role'] === 'Propriétaire') ? 'selected' : ''; ?>>
                                Propriétaire
                            </option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            Photo de profil
                        </label>
                        <input type="file" name="photo" accept="image/*"
                               class="mt-1 block w-full text-sm text-slate-500
                                      file:mr-4 file:py-2 file:px-4
                                      file:rounded-full file:border-0
                                      file:text-sm file:font-semibold
                                      file:bg-violet-50 file:text-violet-700
                                      hover:file:bg-violet-100">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            Description (optionnelle)
                        </label>
                        <textarea name="description" rows="3"
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        ><?php echo isset($old['description']) ? htmlspecialchars($old['description']) : ''; ?></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            Mot de passe
                        </label>
                        <input type="password" name="password"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <?php if (isset($errors['password'])): ?>
                            <p class="mt-2 text-sm text-red-600"><?php echo $errors['password']; ?></p>
                        <?php endif; ?>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            Confirmer le mot de passe
                        </label>
                        <input type="password" name="password_confirm"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <div>
                        <button type="submit"
                                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            S'inscrire
                        </button>
                    </div>
                </form>

                <div class="mt-6">
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-2 bg-white text-gray-500">
                                Ou continuer avec
                            </span>
                        </div>
                    </div>

                    <div class="mt-6 grid grid-cols-2 gap-3">
                        <div>
                            <a href="#" class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                <img class="h-5 w-5" src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google">
                            </a>
                        </div>
                        <div>
                            <a href="#" class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                <img class="h-5 w-5" src="https://www.svgrepo.com/show/475647/facebook-color.svg" alt="Facebook">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>