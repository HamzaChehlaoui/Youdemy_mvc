<?php
require_once('../Controller/controler_dashbord_teacher.php');
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Youdemy - Gestion des cours</title>
    <style>
        /* Base styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f3f4f6;
        }

        .navbar {
            background-color: #000;
            padding: 1rem;
            color: white;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 1rem;
        }

        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            padding: 1.5rem;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .courses-table {
            width: 100%;
            background: white;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            margin-top: 2rem;
        }

        .courses-table th,
        .courses-table td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid #e5e7eb;
        }

        .btn {
            background: #000;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.25rem;
            text-decoration: none;
            display: inline-block;
        }

        .tag {
            background: #e5e7eb;
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            font-size: 0.875rem;
            margin-right: 0.5rem;
        }

        .status {
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            font-size: 0.875rem;
        }

        .status-published { background: #10b981; color: white; }
        .status-draft { background: #6b7280; color: white; }
        .status-archived { background: #ef4444; color: white; }
    </style>
</head>
<body>

    <div class="container">
        <div class="dashboard-header">
            <h2>Gestion des cours</h2>
            <a href="add_cours_teacher.php" class="btn">Ajouter un cours</a>
        </div>

        <div class="courses-table">
            <table width="100%">
                <thead>
                    <tr>
                        <th>Titre</th>
                        <th>Enseignant</th>
                        <th>Catégorie</th>
                        <th>Tags</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Étudiants</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $result = $course->getAllCoursesTeacher($_SESSION["user_id"]);
                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                        $tags = $course->getCourseTags($row['id_courses']);
                        $tagsList = [];
                        while($tag = $tags->fetch(PDO::FETCH_ASSOC)) {
                            $tagsList[] = "<span class='tag'>" . $tag['name'] . "</span>";
                        }
                        ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['title']); ?></td>
                            <td><?php echo htmlspecialchars($row['teacher_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['category_name']); ?></td>
                            <td><?php echo implode(' ', $tagsList); ?></td>
                            <td><?php echo htmlspecialchars($row['content_type']); ?></td>
                            <td><span class="status status-<?php echo $row['status']; ?>">
                                <?php echo htmlspecialchars($row['status']); ?>
                            </span></td>
                            <td><?php echo $row['student_count']; ?></td>
                            <td>
                                <a href="editecours.php?id=<?php echo $row['id_courses']; ?>" class="btn">Modifier</a>
                                <a href="delete_course.php?id=<?php echo $row['id_courses']; ?>" 
                                   class="btn" 
                                   onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce cours?')">Supprimer</a>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>