<?php
// use Connection\database\Database;
// use users\Admin;
require_once "../Controller/Teacher.php";


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
    <div class="max-w-7xl mx-auto px-4 py-8">
        <!-- Teacher Validation Section -->
        <div id="users-tab" class="tab-content">
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-black mb-6">Validation des Enseignants</h2>
                <div class="grid gap-6">
                    <?php
                    $result = $teacher->getAllTeachers();
                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                        $statusClass = $row['status'] === 'active' ? 'bg-green-100 text-green-800' : 
                                    ($row['status'] === 'suspended' ? 'bg-yellow-100 text-yellow-800' : 
                                    'bg-gray-100 text-gray-800');
                        ?>
                        <div class="bg-white rounded-lg shadow-lg p-6">
                            <div class="flex justify-between items-start">
                                <div>
                                
                                    <h3 class="text-xl font-semibold"><?php echo htmlspecialchars($row['username']); ?></h3>
                                    <?php if($row['role']=='teacher') {?>
                                    <p class="text-gray-600"><?php echo $row['course_count']; ?> cours · <?php echo $row['student_count']; ?> étudiants</p>
                                    <?php }?>
                                    <p class="text-gray-600 mt-2">Email: <?php echo htmlspecialchars($row['email']); ?></p>
                                    <div class="mt-2">
                                        <span class="<?php echo $statusClass; ?> text-xs px-2 py-1 rounded">
                                            Status : <?php echo ucfirst($row['status']); ?>
                                        </span>
                                    </div>
                                </div>
                                <div class="flex space-x-2">
                                    <form method="POST" class="inline">
                                        <input type="hidden" name="user_id" value="<?php echo $row['id_user']; ?>">
                                        <input type="hidden" name="action" value="activate">
                                        <button type="submit" 
                                                class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                                            Activer
                                        </button>
                                    </form>
                                    
                                    <form method="POST" class="inline">
                                        <input type="hidden" name="user_id" value="<?php echo $row['id_user']; ?>">
                                        <input type="hidden" name="action" value="suspend">
                                        <button type="submit" 
                                                class="bg-yellow-600 text-white px-4 py-2 rounded hover:bg-yellow-700">
                                            Suspendre
                                        </button>
                                    </form>
                                    
                                    <form method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet enseignant?');">
                                        <input type="hidden" name="user_id" value="<?php echo $row['id_user']; ?>">
                                        <input type="hidden" name="action" value="delete">
                                        <button type="submit" 
                                                class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                                            Supprimer
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>