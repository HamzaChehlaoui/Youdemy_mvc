<?php
require_once('../Controller/Show_cours.php');
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Youdemy - Catalogue des cours</title>
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
                        <a href="#" class="text-white hover:text-gray-300 px-3 py-2">Accueil</a>
                        <a href="#" class="text-white hover:text-gray-300 px-3 py-2">Cours</a>
                        <a href="#" class="text-white hover:text-gray-300 px-3 py-2">Mes Cours</a>
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

    <!-- Database Verification Results -->
    <?php if (isset($dbVerification) && !isset($dbVerification['error'])): ?>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-20">
        <div class="bg-white shadow-sm rounded-lg p-6 mt-4">
            <h2 class="text-xl font-bold mb-4">État de la base de données</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <!-- Users Statistics -->
                <div class="p-4 bg-gray-50 rounded-lg">
                    <h3 class="font-bold text-lg mb-2">Utilisateurs</h3>
                    <?php foreach ($dbVerification['users'] as $userStats): ?>
                        <p>
                            <?= htmlspecialchars($userStats['role']) ?> 
                            (<?= htmlspecialchars($userStats['status']) ?>): 
                            <?= htmlspecialchars($userStats['count']) ?>
                        </p>
                    <?php endforeach; ?>
                </div>
                
                <!-- Categories Statistics -->
                <div class="p-4 bg-gray-50 rounded-lg">
                    <h3 class="font-bold text-lg mb-2">Catégories</h3>
                    <p>Total: <?= htmlspecialchars($dbVerification['categories']['count']) ?></p>
                </div>
                
                <!-- Courses Statistics -->
                <div class="p-4 bg-gray-50 rounded-lg">
                    <h3 class="font-bold text-lg mb-2">Cours</h3>
                    <?php foreach ($dbVerification['courses'] as $courseStats): ?>
                        <p>
                            <?= htmlspecialchars($courseStats['status']) ?>: 
                            <?= htmlspecialchars($courseStats['count']) ?>
                        </p>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <?php if (!empty($dbVerification['orphaned_courses'])): ?>
                <div class="mt-4 p-4 bg-red-100 rounded-lg">
                    <h3 class="font-bold text-lg mb-2">Cours orphelins détectés</h3>
                    <?php foreach ($dbVerification['orphaned_courses'] as $course): ?>
                        <p>ID: <?= htmlspecialchars($course['id_courses']) ?> - 
                           Titre: <?= htmlspecialchars($course['title']) ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>

    <!-- Header -->
    <div class="bg-gradient-to-r from-gray-100 to-white pt-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <h1 class="text-4xl font-bold text-black mb-4">Catalogue des cours</h1>
            <p class="text-xl text-gray-700">Découvrez nos cours et commencez votre apprentissage dès aujourd'hui</p>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <form method="GET" action="" class="flex flex-col md:flex-row gap-4">
                <select name="category" class="px-4 py-2 border rounded-lg">
                    <option value="">Toutes les catégories</option>
                    <?php foreach ($categories as $category): ?>
                                <option value="<?php echo htmlspecialchars($category->id); ?>">
                                    <?php echo htmlspecialchars($category->name); ?>
                                </option>
                    <?php endforeach; ?>
                    
                </select>
                <input type="text" 
                       name="search" 
                       value="<?= htmlspecialchars($searchQuery) ?>"
                       placeholder="Rechercher un cours..." 
                       class="flex-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-black focus:border-black">
                <button type="submit" 
                        class="bg-black text-white px-6 py-2 rounded-lg hover:bg-gray-800 transition-colors">
                    Rechercher
                </button>
            </form>
        </div>
    </div>

    <!-- Course Grid -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <?php if (!empty($courses)): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php foreach ($courses as $course): ?>
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden transition-transform hover:scale-105">
                        <?php if ($course['content_type'] === 'video'): ?>
                            <div class="aspect-w-16 aspect-h-9 bg-gray-100">
                                <img class="w-full h-48 object-cover" src="https://static.vecteezy.com/ti/gratis-vector/p2/6647166-camera-pictogram-logo-fotografie-pictogrammen-set-beveiliging-camera-pictogram-foto-en-video-pictogram-gratis-vector.jpg">
                        </img>
                            </div>
                        <?php else: ?>
                            <div class="w-full h-48 bg-gray-100 flex items-center justify-center">
                                <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                            </div>
                        <?php endif; ?>
                        
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-2">
                                <span class="bg-black text-white text-sm px-3 py-1 rounded-full">
                                    <?= htmlspecialchars($course['category_name']) ?>
                                </span>
                                <span class="text-sm text-gray-500">
                                    <?= $course['enrollment_count'] ?> inscrit(s)
                                </span>
                            </div>
                            
                            <h2 class="text-xl font-bold mb-2">
                                <?= htmlspecialchars($course['title']) ?>
                            </h2>
                            
                            <p class="text-gray-600 mb-4 line-clamp-3">
                                <?= htmlspecialchars($course['description']) ?>
                            </p>
                            
                            <?php if (!empty($course['tags'])): ?>
                                <div class="flex flex-wrap gap-2 mb-4">
                                    <?php foreach ($course['tags'] as $tag): ?>
                                        <span class="bg-gray-100 text-gray-700 px-2 py-1 rounded-full text-sm">
                                            <?= htmlspecialchars($tag['name']) ?>
                                        </span>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                            
                             <div class="flex items-center mb-4">
                                 <img src="../img/teacher.jpg" alt="Instructor" class="w-8 h-8 rounded-full">
                                <span class="ml-2 text-gray-700">
                                    Par <?= htmlspecialchars($course['teacher_name']) ?>
                                </span>
                            </div>
                            
                            <div class="flex justify-end">
                                <a href="Course_Detail_Page_student.php?id=<?= $course['id_courses'] ?>" 
                                   class="bg-black text-white px-4 py-2 rounded-lg hover:bg-gray-800">
                                    Voir le cours
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="text-center py-8">
                <p class="text-xl text-gray-600">Aucun cours trouvé.</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Pagination -->
   <!-- Pagination -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <?php if ($totalPages > 1): ?>
        <div class="flex justify-center space-x-2">
            <?php if ($currentPage > 1): ?>
                <a href="?page=<?= $currentPage - 1 ?><?= $categoryId ? '&category=' . $categoryId : '' ?><?= $searchQuery ? '&search=' . urlencode($searchQuery) : '' ?>" 
                   class="px-4 py-2 border rounded-lg hover:bg-gray-100">
                    Précédent
                </a>
            <?php endif; ?>
            
            <?php
            $startPage = max(1, $currentPage - 2);
            $endPage = min($totalPages, $startPage + 4);
            if ($endPage - $startPage < 4) {
                $startPage = max(1, $endPage - 4);
            }
            
            for ($i = $startPage; $i <= $endPage; $i++):
            ?>
                <a href="?page=<?= $i ?><?= $categoryId ? '&category=' . $categoryId : '' ?><?= $searchQuery ? '&search=' . urlencode($searchQuery) : '' ?>"
                   class="px-4 py-2 <?= $i === $currentPage ? 'bg-black text-white' : 'border hover:bg-gray-100' ?> rounded-lg">
                    <?= $i ?>
                </a>
            <?php endfor; ?>
            
            <?php if ($currentPage < $totalPages): ?>
                <a href="?page=<?= $currentPage + 1 ?><?= $categoryId ? '&category=' . $categoryId : '' ?><?= $searchQuery ? '&search=' . urlencode($searchQuery) : '' ?>" 
                   class="px-4 py-2 border rounded-lg hover:bg-gray-100">
                    Suivant
                </a>
            <?php endif; ?>
        </div>
        
        <div class="text-center mt-4 text-gray-600">
            Page <?= $currentPage ?> sur <?= $totalPages ?>
        </div>
    <?php endif; ?>
</div>

    <!-- Footer -->
    <footer class="bg-black text-white py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <p class="text-center">&copy; 2025 Youdemy. Tous droits réservés.</p>
        </div>
    </footer>
</body>
</html>