<?php
$currentTab = $_GET['tab'] ?? 'active';
require_once('../Controller/controler_my_cours_student.php');
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Youdemy - Mes Cours</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white text-black">
   <?php require_once('../Views/nav/Navbar_student.php')?>

    <!-- Header -->
    <div class="bg-gradient-to-r from-white to-gray-200 pt-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <h1 class="text-3xl font-bold text-black mb-4">Mes Cours</h1>
            <p class="text-gray-700">Continuez votre apprentissage</p>
        </div>
    </div>

    <!-- Course Tabs -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="border-b border-gray-200 mb-8">
            <nav class="-mb-px flex space-x-8">
                <a href="?tab=active" 
                   class="border-b-2 <?php echo $currentTab === 'active' ? 'border-black' : 'border-transparent'; ?> pb-4 px-1 text-black font-medium">
                    En cours
                </a>
            </nav>
        </div>

        <!-- Course Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php
            $coursesToDisplay = [];
            switch($currentTab) {
                case 'active':
                    $coursesToDisplay = $activeCourses;
                    break;
                case 'pending':
                    $coursesToDisplay = $pendingCourses;
                    break;
                case 'completed':
                    $coursesToDisplay = $completedCourses;
                    break;
            }

            foreach($coursesToDisplay as $course):
            ?>
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQpuYdLEzBvwemix8pwsncUkLLOQqnByncadg&s" 
                     alt="<?php echo htmlspecialchars($course['title']); ?>" 
                     class="w-full h-48 object-cover">
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-black mb-2">
                        <?php echo htmlspecialchars($course['title']); ?>
                    </h3>
                    <?php if($currentTab === 'active'): ?>
                        <div class="flex items-center mb-4">
                            <div class="h-2 bg-gray-200 rounded-full flex-grow">
                                <div class="h-2 bg-black rounded-full" style="width: 60%"></div>
                            </div>
                            
                        </div>
                        <a href="<?php echo $course['content_url'];?>"
                           class="block w-full bg-black text-white px-4 py-2 rounded-lg hover:bg-gray-800 text-center">
                            Continuer le cours
                        </a>
                    <?php elseif($currentTab === 'pending'): ?>
                        <p class="text-gray-600 mb-4">En attente d'approbation</p>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-500">
                                Demande envoyée le <?php echo date('d/m/Y', strtotime($course['enrollment_date'])); ?>
                            </span>
                        </div>
                    <?php else: ?>
                        <p class="text-gray-600 mb-4">Cours terminé</p>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-500">
                                Terminé le <?php echo date('d/m/Y', strtotime($course['enrollment_date'])); ?>
                            </span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>