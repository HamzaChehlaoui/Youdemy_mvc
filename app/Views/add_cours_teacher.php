<?php
require_once ('../Controller/Add_Cours.php');
// session_start();
if($_SESSION['role']!='teacher'){
    header('Location:login.php');
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Youdemy - Ajouter un cours</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <!-- Navigation bar remains unchanged -->
    <nav class="fixed top-0 w-full bg-black shadow-sm z-50">
        <!-- ... existing nav content ... -->
    </nav>

    <div class="pt-24 pb-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <?php if (isset($error)): ?>
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <?php if (isset($success)): ?>
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                    <?php echo htmlspecialchars($success); ?>
                </div>
            <?php endif; ?>

            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Ajouter un nouveau cours</h2>
                    
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" class="space-y-6">
                        <!-- Title field remains unchanged -->
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700">Titre du cours</label>
                            <input type="text" name="title" id="title" required 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-black focus:ring-black sm:text-sm">
                        </div>

                        <!-- Description field remains unchanged -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea id="description" name="description" rows="4" required 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-black focus:ring-black sm:text-sm"></textarea>
                        </div>

                        <!-- Modified content type selection -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Type de contenu</label>
                            <div class="flex space-x-4">
                                <label class="inline-flex items-center">
                                    <input type="radio" name="content_type" value="video" checked 
                                        class="form-radio text-black focus:ring-black" onchange="toggleContentInput()">
                                    <span class="ml-2">Vidéo</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="content_type" value="document" 
                                        class="form-radio text-black focus:ring-black" onchange="toggleContentInput()">
                                    <span class="ml-2">Document</span>
                                </label>
                            </div>
                        </div>

                        <!-- Modified content input -->
                        <div id="videoInput">
                            <label for="video_url" class="block text-sm font-medium text-gray-700">URL de la vidéo</label>
                            <input type="url" name="video_url" id="video_url" placeholder="https://www.youtube.com/watch?v=..."
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-black focus:ring-black sm:text-sm">
                        </div>

                        <div id="documentInput" style="display: none;">
                            <label for="document_url" class="block text-sm font-medium text-gray-700">URL du document</label>
                            <input type="url" name="document_url" id="document_url" placeholder="https://drive.google.com/..."
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-black focus:ring-black sm:text-sm">
                        </div>

                        <!-- Category selection remains unchanged -->
                        <div>
                            <label for="category" class="block text-sm font-medium text-gray-700">Catégorie</label>
                            <select id="category" name="category" required 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-black focus:ring-black sm:text-sm">
                                <option value="">Sélectionnez une catégorie</option>
                                <?php foreach ($categories as $category): ?>
                                <option value="<?php echo htmlspecialchars($category->id); ?>">
                                    <?php echo htmlspecialchars($category->name); ?>
                                </option>
                    <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Modified tags selection -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tags</label>
                            <div class="grid grid-cols-3 gap-4">
                                <?php foreach ($tags as $tag): ?>
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" name="tags[]" value="<?php echo htmlspecialchars($tag['id_tags']); ?>"
                                            class="form-checkbox text-black focus:ring-black">
                                        <span class="ml-2"><?php echo htmlspecialchars($tag['name']); ?></span>
                                    </label>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <div class="pt-4">
                            <button type="submit" 
                                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-black hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black">
                                Créer le cours
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
    function toggleContentInput() {
        const videoInput = document.getElementById('videoInput');
        const documentInput = document.getElementById('documentInput');
        const contentType = document.querySelector('input[name="content_type"]:checked').value;
        
        if (contentType === 'video') {
            videoInput.style.display = 'block';
            documentInput.style.display = 'none';
            document.getElementById('document_url').value = '';
        } else {
            videoInput.style.display = 'none';
            documentInput.style.display = 'block';
            document.getElementById('video_url').value = '';
        }
    }
    </script>
</body>
</html>