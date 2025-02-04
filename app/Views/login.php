<?php
include '../Controller/login_chek.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Youdemy - Connexion</title>
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
            </div>
        </div>
    </nav>

    <?php if ($error): ?>
        <div class="fixed top-20 right-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
            <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>
    
    <?php if ($success): ?>
        <div class="fixed top-20 right-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
            <?php echo htmlspecialchars($success); ?>
        </div>
    <?php endif; ?>

    <!-- Connection Forms Section -->
    <div class="min-h-screen pt-24 pb-16 flex items-center">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
            <div class="bg-white rounded-lg shadow-xl p-8">
                <!-- Tabs -->
                <div class="flex border-b border-gray-200 mb-8">
                    <button id="loginTab" class="px-6 py-2 text-lg font-semibold text-black border-b-2 border-black">
                        Connexion
                    </button>
                    <button id="registerTab" class="px-6 py-2 text-lg font-semibold text-gray-500 hover:text-black">
                        Inscription
                    </button>
                </div>

                <!-- Login Form -->
                <div id="loginForm" class="space-y-6">
                    <form method="POST" action="">
                        <input type="hidden" name="action" value="login">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                            <input type="email" name="email" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-black">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Mot de passe</label>
                            <input type="password" name="password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-black">
                        </div>
                        <div class="flex items-center justify-between">
                        </div>
                        <button type="submit" class="w-full bg-black mt-[1rem] text-white px-4 py-2 rounded-lg hover:bg-gray-800">
                            Se connecter
                        </button>
                    </form>
                </div>

                <!-- Register Form -->
                <div id="registerForm" class="space-y-6 hidden">
                    <form method="POST" action="">
                        <input type="hidden" name="action" value="register">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nom complet</label>
                            <input type="text" name="username" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-black">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                            <input type="email" name="email" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-black">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Mot de passe</label>
                            <input type="password" name="password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-black">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Confirmer le mot de passe</label>
                            <input type="password" name="confirm_password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-black">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Rôle</label>
                            <select name="role" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-black">
                                <option value="student">Étudiant</option>
                                <option value="teacher">Formateur</option>
                            </select>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" name="terms" required class="h-4 w-4 border-gray-300 rounded">
                            <label class="ml-2 text-sm text-gray-700">J'accepte les conditions d'utilisation et la politique de confidentialité</label>
                        </div>
                        <button type="submit" class="w-full bg-black text-white px-4 py-2 rounded-lg hover:bg-gray-800">
                            Créer un compte
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Your existing JavaScript for tab switching
        let loginTab = document.getElementById('loginTab');
        let registerTab = document.getElementById('registerTab');
        let loginForm = document.getElementById('loginForm');
        let registerForm = document.getElementById('registerForm');

        loginTab.addEventListener('click', () => {
            loginTab.classList.add('text-black', 'border-b-2', 'border-black');
            loginTab.classList.remove('text-gray-500');
            registerTab.classList.remove('text-black', 'border-b-2', 'border-black');
            registerTab.classList.add('text-gray-500');
            loginForm.classList.remove('hidden');
            registerForm.classList.add('hidden');
        });

        registerTab.addEventListener('click', () => {
            registerTab.classList.add('text-black', 'border-b-2', 'border-black');
            registerTab.classList.remove('text-gray-500');
            loginTab.classList.remove('text-black', 'border-b-2', 'border-black');
            loginTab.classList.add('text-gray-500');
            registerForm.classList.remove('hidden');
            loginForm.classList.add('hidden');
        });
    </script>
</body>
</html>