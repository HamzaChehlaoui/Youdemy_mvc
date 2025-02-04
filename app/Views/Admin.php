<?php 
session_start();
if($_SESSION['role']!='admin'){
    header('Location:login.php');
}
require_once "../Controller/Gere_gategory_tags.php";
require_once "../Controller/Teacher.php";

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Youdemy - Administration</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <!-- Navigation -->
    <nav class="fixed top-0 w-full bg-black shadow-sm z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="#" class="text-2xl font-bold text-white">Youdemy Admin</a>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-white">Admin</span>
                    <a href="loug_out.php" class="text-white hover:text-gray-300">Déconnexion</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="pt-16">
        <!-- Tabs -->
        <div class="bg-white shadow">
            <div class="max-w-7xl mx-auto">
                <div class="flex space-x-8 px-4" role="tablist" id="tabs">
                    <button class="px-4 py-4 text-sm font-medium text-black border-b-2 border-black" role="tab" onclick="switchTab('users')">
                        Gestion des Utilisateurs
                    </button>
                    <button class="px-4 py-4 text-sm font-medium text-gray-500 hover:text-black" role="tab" onclick="switchTab('content')">
                        Gestion du Contenu
                    </button>
                    <button class="px-4 py-4 text-sm font-medium text-gray-500 hover:text-black" role="tab" onclick="switchTab('stats')">
                        Statistiques
                    </button>
                </div>
            </div>
        </div>

        <!-- Dashboard Content -->
        <div class="max-w-7xl mx-auto px-4 py-8">
            <!-- Teacher Validation Section -->
    
        <?php 
        require('active_teacher.php');
        require('Content_Management.php');
        ?>

        
    
    </div>
</div>

            <!-- Statistics Section -->
            <div id="stats-tab" class="tab-content hidden">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Total Courses by Category -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h3 class="text-lg font-semibold mb-4">Total des Cours par Catégorie</h3>
            <div class="space-y-4">
                <?php foreach ($coursesByCategory as $category): ?>
                <div class="flex justify-between">
                    <span> <?php echo htmlspecialchars($category['category_name']); ?></span>
                    <span class="font-bold"><?php echo $category['course_count']; ?></span>
                </div>
                <?php endforeach;?>
            </div>
        </div>

        <!-- Top 3 Teachers -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h3 class="text-lg font-semibold mb-4">Top 3 Enseignants</h3>
            <div class="space-y-4">
                <?php foreach ($topTeachers as $teacher): ?>
                <div class="flex justify-between">
                    <span><?php echo htmlspecialchars($teacher['username']); ?></span>
                    <span class="font-bold"><?php echo $teacher['student_count']; ?> étudiants</span>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Most Popular Course -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h3 class="text-lg font-semibold mb-4">Cours le Plus Populaire</h3>
            <?php if ($mostPopularCourse): ?>
            <div class="space-y-2">
                <p class="font-bold"><?php echo htmlspecialchars($mostPopularCourse['title']); ?></p>
                <p class="text-gray-600">Par <?php echo htmlspecialchars($mostPopularCourse['teacher_name']); ?></p>
                <p class="text-green-600"><?php echo $mostPopularCourse['student_count']; ?> étudiants inscrits</p>
                <div class="mt-4">
                    <div class="h-2 bg-gray-200 rounded">
                        <?php 
                        $percentage = ($mostPopularCourse['student_count'] / $mostPopularCourse['total_enrollments']) * 100;
                        ?>
                        <div class="h-2 bg-green-600 rounded" style="width: <?php echo $percentage; ?>%"></div>
                    </div>
                </div>
            </div>
            <?php else: ?>
            <p class="text-gray-600">Aucun cours disponible</p>
            <?php endif;?>
        </div>
    </div>
            </div>
        </div>
    </div>

    <script>
        function switchTab(tabName) {
            // Hide all tab contents
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.add('hidden');
            });
            
            // Show selected tab content
            document.getElementById(tabName + '-tab').classList.remove('hidden');
            
            // Update tab styles
            document.querySelectorAll('[role="tab"]').forEach(tab => {
                tab.classList.remove('text-black', 'border-b-2', 'border-black');
                tab.classList.add('text-gray-500');
            });
            
            // Style active tab
            event.target.classList.remove('text-gray-500');
            event.target.classList.add('text-black', 'border-b-2', 'border-black');
        }
    </script>
</body>
</html>