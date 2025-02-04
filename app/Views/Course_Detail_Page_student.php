<?php
require_once('../Controller/Detail_cours.php');
session_start();
if($_SESSION['role']!='student'){
    header('Location:login.php');
}
$courseId = isset($_GET['id']) ? intval($_GET['id']) : 0;

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Youdemy - <?= htmlspecialchars($courseDetails['title']) ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white text-black">

    <!-- Navigation remains the same -->
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

    <!-- Course Header -->
    <div class="pt-24 min-h-screen bg-pattern bg-cover bg-top">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div>
                    <span class="bg-black text-white text-sm px-3 py-1 rounded-full">
                        <?= htmlspecialchars($courseDetails['category_name']) ?>
                    </span>
                    <h1 class="text-4xl font-bold text-gray-800 mt-4 mb-4">
                        <?= htmlspecialchars($courseDetails['title']) ?>
                    </h1>
                    <p class="text-xl text-gray-600 mb-6">
                        <?= htmlspecialchars($courseDetails['description'])?>
                    </p>
                    
                    <div class="flex items-center mb-4">
                        <img src="../img/teacher.jpg" alt="Instructor" class="w-10 h-10 rounded-full">
                        <span class="ml-2 text-gray-700">Par <?= htmlspecialchars($courseDetails['teacher_name']) ?></span>
                    </div>
                    
                    <?php if (!empty($courseDetails['tags'])): ?>
                    <div class="flex flex-wrap gap-2 mb-4">
                        <?php foreach ($courseDetails['tags'] as $tag): ?>
                            <span class="bg-gray-100 text-gray-700 px-2 py-1 rounded-full text-sm">
                                <?= htmlspecialchars($tag['name']) ?>
                            </span>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                </div>
                
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <div class="aspect-w-16 aspect-h-9">
                        <img src="../img/Black Grey Minimalist Book Club Logo_LE_upscale_digital_art_x4.jpg" alt="Course Image" class="w-full h-[250px] object-cover rounded-lg shadow">
                    </div>
                    <a href="Inscription_Cours.php?id=<?= $courseId?>">
                        <button class="w-full bg-black text-white px-6 py-3 rounded-lg hover:bg-gray-800 mt-6">
                            Inscrivez-vous au cours
                        </button>
                    </a>
                    
                    <div class="space-y-4 text-gray-700 mt-6">
                        <div class="flex items-center">
                            <span class="mr-2">✓</span>
                            <span>30 jours d'accès illimité</span>
                        </div>
                        <div class="flex items-center">
                            <span class="mr-2">✓</span>
                            <span>
                                <?= $courseDetails['content_type'] === 'video' ? 'Vidéos à votre rythme' : 'Documents téléchargeables' ?>
                            </span>
                        </div>
                        <div class="flex items-center">
                            <span class="mr-2">✓</span>
                            <span>Certification à la fin du cours</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Course Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column: Details -->
            <div class="lg:col-span-2">

                <!-- Course Description -->
                <div class="bg-white p-6 rounded-lg shadow-lg mb-8">
                    <h2 class="text-2xl font-bold mb-4">Description du cours</h2>
                    <div class="prose max-w-none">
                        <p class="mb-4">
                            <?= nl2br(htmlspecialchars($courseDetails['description'])) ?>
                        </p>
                    </div>
                </div>

                <!-- Course Content -->
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <h2 class="text-2xl font-bold mb-4">Contenu du cours</h2>
                    <div class="space-y-4">
                        <div class="border rounded-lg">
                            <div class="p-4 bg-gray-50 flex justify-between items-center">
                                <h3 class="font-semibold"><?= htmlspecialchars($courseDetails['content_title'] ?? 'Contenu') ?></h3>
                            </div>
                            <div class="p-4 space-y-2">
                                <div class="flex items-center">
                                    <span class="mr-2">
                                        <?= $courseDetails['content_type'] === 'video' ? '📹' : '📄' ?>
                                    </span>
                                    <span><?= htmlspecialchars($courseDetails['description']) ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Instructor -->
            <div>
                <!-- Instructor -->
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <h2 class="text-xl font-bold mb-4">À propos de l'instructeur</h2>
                    <div class="flex items-center mb-4">
                        <img src="../img/teacher.jpg" alt="Instructor" class="w-20 h-20 rounded-full">
                        <div class="ml-4">
                            <h3 class="font-semibold"><?= htmlspecialchars($courseDetails['teacher_name']) ?></h3>
                            <p class="text-gray-600"><?= htmlspecialchars($courseDetails['teacher_biography'] ?? '') ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
