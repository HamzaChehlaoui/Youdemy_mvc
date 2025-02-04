<?php
require_once('../Controller/controler_EnrollmentManager.php');

?>;

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Youdemy - Inscription au cours</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white text-black">
    <!-- Navigation -->
    <nav class="fixed top-0 w-full bg-black shadow-sm z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="#" class="text-2xl font-bold text-white">Youdemy</a>
                    <div class="hidden md:flex space-x-8 ml-10">
                        <a href="index.php" class="text-white hover:text-gray-300 px-3 py-2">Accueil</a>
                        
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <button class="bg-white text-black px-4 py-2 rounded-lg hover:bg-gray-100">
                        Mon Compte
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Registration Form Section -->
    <div class="pt-24 min-h-screen">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="bg-white p-8 rounded-lg shadow-lg">
                <h1 class="text-3xl font-bold text-gray-800 mb-6">Inscription au cours</h1>
                
                <!-- Course Summary -->
                <div class="mb-8 p-4 bg-gray-50 rounded-lg">
                    <div class="flex items-center mb-4">
                        <img src="../img/Black Grey Minimalist Book Club Logo_LE_upscale_digital_art_x4.jpg" 
                             alt="Course Image" 
                             class="w-16 h-16 object-cover rounded">
                        <div class="ml-4">
                            <h2 class="text-xl font-bold"><?= htmlspecialchars($courseDetails['title']) ?></h2>
                            <p class="text-gray-600">Par <?= htmlspecialchars($courseDetails['teacher_name']) ?></p>
                        </div>
                    </div>
                </div>

                <!-- Registration Form -->
                <form action="" method="POST" class="space-y-6">
                    
                    
                    <!-- Personal Information -->
                    <div class="space-y-4">
                        <h3 class="text-xl font-semibold mb-4">Informations personnelles</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-1 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Prénom et Nom</label>
                                <input type="text" name="firstname" required
                                    value="<?php echo $_SESSION['username']?>"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-black">
                            </div>
                            
                        </div>
                        
                    </div>

                    <!-- Terms and Conditions -->
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <input type="checkbox" name="terms" required
                                   class="mt-1 mr-2">
                            <label class="text-sm text-gray-600">
                                J'accepte les conditions générales d'utilisation et la politique de confidentialité
                            </label>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" 
                            class="w-full bg-black text-white px-6 py-3 rounded-lg hover:bg-gray-800 transition-colors">
                        Confirmer l'inscription
                    </button>
                </form>

                <!-- Additional Information -->
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <h3 class="text-lg font-semibold mb-4">Ce que vous obtenez</h3>
                    <div class="space-y-3 text-gray-600">
                        <div class="flex items-center">
                            <span class="mr-2">✓</span>
                            <span>Accès illimité au contenu du cours</span>
                        </div>
                        <div class="flex items-center">
                            <span class="mr-2">✓</span>
                            <span>Certificat d'achèvement</span>
                        </div>
                        <div class="flex items-center">
                            <span class="mr-2">✓</span>
                            <span>Support de l'instructeur</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>