<?php 
require_once "../Controller/Gere_gategory_tags.php";

$selectedCategory = $_GET['category_id'] ?? '';
$selectedTag = $_GET['tag_id'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
<div id="content-tab" class="tab-content hidden">
    <div class="grid gap-6">
        <!-- Tags and Categories Management -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Tag Management -->
                <div>
                    <h2 class="text-xl font-bold text-black mb-4">Gestion des Tags</h2>
                    <div class="mb-4">
                        <form method="POST">
                            <input type="hidden" name="action" value="addTag">
                            <input type="text" name="name" id="newTag" placeholder="Nouveau tag" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md">
                            <button type="submit" class="mt-2 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                                Ajouter un tag
                            </button>
                        </form>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <?php foreach ($tags as $tag): ?>
                        <div class="inline-flex items-center bg-gray-100 rounded-full px-3 py-1">
                            <span><?php echo htmlspecialchars($tag['name']); ?></span>
                            <form method="POST" style="display: inline;">
                                <input type="hidden" name="action" value="deleteTag">
                                <input type="hidden" name="id" value="<?php echo $tag['id_tags']; ?>">
                                <button type="submit" class="ml-2 text-red-600 hover:text-red-800">&times;</button>
                            </form>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                
                <!-- Category Management -->
                <div>
                    <h2 class="text-xl font-bold text-black mb-4">Gestion des Catégories</h2>
                    <div class="mb-4">
                        <form method="POST">
                            <input type="hidden" name="action" value="addCategory">
                            <input type="text" name="name" id="newCategory" placeholder="Nouvelle catégorie" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md">
                            <button type="submit" class="mt-2 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                                Ajouter une catégorie
                            </button>
                        </form>
                    </div>
                    <div class="space-y-2">
                
                        <?php foreach ($categories as $category): ?>
                        <div class="flex justify-between items-center p-2 bg-gray-50 rounded">
                            <span><?php echo htmlspecialchars($category->name); ?></span>
                            <div class="flex space-x-2">
                                <form method="POST" style="display: inline;">
                                    <input type="hidden" name="action" value="deleteCategory">
                                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($category->id); ?>">
                                    <button type="submit" class="text-red-600 hover:text-red-800">Supprimer</button>
                                </form>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Course Management -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-2xl font-bold text-black mb-6">Gestion des Cours</h2>
            
            <!-- Filters -->
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Catégorie</label>
                    <select onchange="this.form.submit()" name="category_id" form="filter-form"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        <option value="">Toutes les catégories</option>
                        <?php foreach ($categories as $category): ?>
                                <option value="<?php echo htmlspecialchars($category->id); ?>">
                                    <?php echo htmlspecialchars($category->name); ?>
                                </option>
                    <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Filtrer par tag</label>
                    <select onchange="this.form.submit()" name="tag_id" form="filter-form"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        <option value="">Tous les tags</option>
                        <?php foreach ($tags as $tag): ?>
                            <option value="<?php echo $tag['id_tags']; ?>"
                                    <?php echo $selectedTag == $tag['id_tags'] ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($tag['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <form id="filter-form" method="GET"></form>

            <!-- Courses Table -->
            <table class="min-w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Titre</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Enseignant</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Catégorie</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tags</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Étudiants</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach ($courses as $course): 
                        $courseTags = $courseManager->getCourseTags($course['id_courses']);
                    ?>
                    <tr>
                        <td class="px-6 py-4"><?php echo htmlspecialchars($course['title']); ?></td>
                        <td class="px-6 py-4"><?php echo htmlspecialchars($course['teacher_name']); ?></td>
                        <td class="px-6 py-4"><?php echo htmlspecialchars($course['category_name']); ?></td>
                        <td class="px-6 py-4">
                            <div class="flex flex-wrap gap-1">
                                <?php foreach ($courseTags as $tag): ?>
                                    <span class="inline-block bg-gray-100 rounded-full px-2 py-1 text-xs">
                                        <?php echo htmlspecialchars($tag['name']); ?>
                                    </span>
                                <?php endforeach; ?>
                            </div>
                        </td>
                        <td class="px-6 py-4"><?php echo $course['student_count']; ?></td>
                        <td class="px-6 py-4">
                            <form method="POST" style="display: inline;">
                                <input type="hidden" name="action" value="deleteCourse">
                                <input type="hidden" name="id" value="<?php echo $course['id_courses']; ?>">
                                <button type="submit" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce cours ?')"
                                        class="text-red-600 hover:text-red-800 ml-4">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>
