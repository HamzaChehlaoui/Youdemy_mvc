<?php 
session_start();
if($_SESSION['role']!='teacher'){
    header('Location:login.php');
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Youdemy - Gestion des cours</title>
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
                        <a href="loug_out.php" class="text-white hover:text-gray-300 px-3 py-2"> Déconnexion</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
   <?php require_once('statistic_teacher.php');
   require_once('Course_Management.php');
   
   ?>

        

        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-black text-white text-center py-4 mt-12">
        <p>&copy; 2025 Youdemy. Tous droits réservés.</p>
    </footer>

</body>
</html>
