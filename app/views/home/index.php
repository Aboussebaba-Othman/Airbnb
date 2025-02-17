<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home - Airbnb</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gray-50">

  <header class="sticky top-0 bg-white shadow-sm z-50">
    <div class="container mx-auto px-4 py-4">
      <div class="flex items-center justify-between">

        <a href="#" class="flex items-center space-x-2">
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


<div class="container mx-auto px-4 py-6">
    <div class="flex justify-center space-x-8 overflow-x-auto pb-4">
      <button class="flex flex-col items-center space-y-2 min-w-[80px] text-rose-500">
        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 22l9-4.5-9-4.5-9 4.5 9 4.5z"></path>
        </svg>
        <span class="text-sm font-medium">Appartement</span>
      </button>
  
      <button class="flex flex-col items-center space-y-2 min-w-[80px] text-gray-500 hover:text-rose-500">
        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 12l1-1 7-7 7 7 1 1v7a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4H9v4a1 1 0 01-1 1H4a1 1 0 01-1-1v-7z"></path>
        </svg>
        <span class="text-sm font-medium">Maison</span>
      </button>
      <button class="flex flex-col items-center space-y-2 min-w-[80px] text-gray-500 hover:text-rose-500">
        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 21h8a2 2 0 002-2V7L12 3 6 7v12a2 2 0 002 2z"></path>
        </svg>
        <span class="text-sm font-medium">Villa</span>
      </button>
 
      <button class="flex flex-col items-center space-y-2 min-w-[80px] text-gray-500 hover:text-rose-500">
        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3L4 21h16L12 3zM12 9v4"></path>
        </svg>
        <span class="text-sm font-medium">Cabane</span>
      </button>
    </div>
  </div>
  



  <main class="container mx-auto px-4 py-8">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
      <div class="group">
        <div class="relative aspect-square rounded-xl overflow-hidden">
          <img
            src="https://via.placeholder.com/400x300"
            alt="Villa de luxe avec piscine"
            class="object-cover w-full h-full group-hover:scale-105 transition-transform duration-200"
          />
          <button class="absolute top-4 right-4 p-2 rounded-full bg-white shadow-md hover:scale-110 transition-transform">
            ♥
          </button>
        </div>
        <div class="mt-4 space-y-2">
          <div class="flex justify-between items-start">
            <h3 class="font-medium text-lg">Villa de luxe avec piscine</h3>
            <div class="flex items-center space-x-1">
              <span>⭐</span>
              <span>4.8</span>
            </div>
          </div>
          <p class="text-gray-500">Nice, France</p>
          <p class="font-medium">250€ / nuit</p>
         
          <div class="flex justify-end">
            <a href="/annonces">
            <button class="bg-rose-500 text-white py-2 px-4 rounded-lg hover:bg-rose-600 transition-colors">
              Réserver
            </button>
            </a>
          </div>
        </div>
      </div>
    </div>
  </main>
</body>
</html>
