<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Youdemy - Gestion des cours et inscriptions</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="fixed top-0 w-full bg-black shadow-sm z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="#" class="text-2xl font-bold text-white">Youdemy</a>
                    <div class="hidden md:flex space-x-8 ml-10">
                        <a href="#" class="text-white hover:text-gray-300 px-3 py-2">Dashboard</a>
                        <a href="#" class="text-white hover:text-gray-300 px-3 py-2">Mes Cours</a>
                        <a href="#" class="text-white hover:text-gray-300 px-3 py-2">Statistiques</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="pt-16 pb-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Course Section -->
            <div class="px-4 py-6 sm:px-0">
                <div class="flex justify-between items-center">
                    <h1 class="text-3xl font-bold text-gray-900">Gestion des cours</h1>
                    <div class="ml-4">
                        <input type="text" placeholder="Rechercher un cours..." class="shadow-sm focus:ring-black focus:border-black block w-full sm:text-sm border-gray-300 rounded-md">
                    </div>
                </div>

                <!-- Course List -->
                <div class="mt-8 bg-white shadow overflow-hidden sm:rounded-md">
                    <ul class="divide-y divide-gray-200">
                        <!-- Course Item -->
                        <li>
                            <div class="px-4 py-4 sm:px-6">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <img class="h-12 w-12 rounded-lg" src="/api/placeholder/48/48" alt="Course thumbnail">
                                        </div>
                                        <div class="ml-4">
                                            <h2 class="text-lg font-medium text-gray-900">Introduction à React</h2>
                                            <p class="text-sm text-gray-500">Prof: Marie Dubois</p>
                                        </div>
                                    </div>
                                    <div>
                                        <span class="inline-flex rounded-full bg-green-100 px-2 py-1 text-xs font-semibold text-green-800">Actif</span>
                                    </div>
                                </div>

                                <!-- Enrollment Management Section -->
                                <div class="mt-4">
                                    <h3 class="text-sm font-medium text-gray-900">Inscriptions (32)</h3>
                                    <div class="mt-2 overflow-hidden">
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <thead class="bg-gray-50">
                                                <tr>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Étudiant</th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date d'inscription</th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Progression</th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200">
                                                <tr>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="flex items-center">
                                                            <div class="flex-shrink-0 h-8 w-8">
                                                                <img class="h-8 w-8 rounded-full" src="/api/placeholder/32/32" alt="">
                                                            </div>
                                                            <div class="ml-4">
                                                                <div class="text-sm font-medium text-gray-900">Jean Martin</div>
                                                                <div class="text-sm text-gray-500">jean.martin@example.com</div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">15/01/2024</td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="flex items-center">
                                                            <div class="w-48 bg-gray-200 rounded-full h-2">
                                                                <div class="bg-black h-2 rounded-full" style="width: 60%"></div>
                                                            </div>
                                                            <span class="ml-2 text-sm text-gray-500">60%</span>
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                        <div class="flex space-x-2">
                                                            <button class="text-indigo-600 hover:text-indigo-900">Voir détails</button>
                                                            <button class="text-yellow-600 hover:text-yellow-900">Modifier</button>
                                                            <button class="text-red-600 hover:text-red-900">Supprimer</button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- Course Actions -->
                                <div class="mt-4 flex justify-end space-x-3">
                                    <button class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black">
                                        Modifier le cours
                                    </button>
                                    <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-black hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black">
                                        Gérer les inscriptions
                                    </button>
                                </div>
                            </div>
                        </li>

                        <!-- Second Course Item -->
                        <li>
                            <div class="px-4 py-4 sm:px-6">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <img class="h-12 w-12 rounded-lg" src="/api/placeholder/48/48" alt="Course thumbnail">
                                        </div>
                                        <div class="ml-4">
                                            <h2 class="text-lg font-medium text-gray-900">Python pour débutants</h2>
                                            <p class="text-sm text-gray-500">Prof: Pierre Durand</p>
                                        </div>
                                    </div>
                                    <div>
                                        <span class="inline-flex rounded-full bg-green-100 px-2 py-1 text-xs font-semibold text-green-800">Actif</span>
                                   </div>
                                </div>

                                <!-- Enrollment Management Section -->
                                <div class="mt-4">
                                    <h3 class="text-sm font-medium text-gray-900">Inscriptions (28)</h3>
                                    <div class="mt-2 overflow-hidden">
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <thead class="bg-gray-50">
                                                <tr>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Étudiant</th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date d'inscription</th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Progression</th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200">
                                                <tr>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="flex items-center">
                                                            <div class="flex-shrink-0 h-8 w-8">
                                                                <img class="h-8 w-8 rounded-full" src="/api/placeholder/32/32" alt="">
                                                            </div>
                                                            <div class="ml-4">
                                                                <div class="text-sm font-medium text-gray-900">Sophie Lambert</div>
                                                                <div class="text-sm text-gray-500">sophie.l@example.com</div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">12/01/2024</td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="flex items-center">
                                                            <div class="w-48 bg-gray-200 rounded-full h-2">
                                                                <div class="bg-black h-2 rounded-full" style="width: 25%"></div>
                                                            </div>
                                                            <span class="ml-2 text-sm text-gray-500">25%</span>
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                        <div class="flex space-x-2">
                                                            <button class="text-indigo-600 hover:text-indigo-900">Voir détails</button>
                                                            <button class="text-yellow-600 hover:text-yellow-900">Modifier</button>
                                                            <button class="text-red-600 hover:text-red-900">Supprimer</button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- Course Actions -->
                                <div class="mt-4 flex justify-end space-x-3">
                                    <button class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black">
                                        Modifier le cours
                                    </button>
                                    <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-black hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black">
                                        Gérer les inscriptions
                                    </button>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</body>
</html>