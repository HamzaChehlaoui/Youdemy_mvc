<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'YouDeMe - Learning Platform' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="/">YouDeMe</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="/courses">Courses</a></li>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <?php if ($_SESSION['role'] === 'teacher'): ?>
                            <li class="nav-item"><a class="nav-link" href="/teacher/dashboard">Dashboard</a></li>
                        <?php elseif ($_SESSION['role'] === 'student'): ?>
                            <li class="nav-item"><a class="nav-link" href="/student/courses">My Courses</a></li>
                        <?php endif; ?>
                    <?php endif; ?>
                </ul>
                <div class="navbar-nav">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <span class="nav-item nav-link">Welcome, <?= htmlspecialchars($_SESSION['username']) ?></span>
                        <a class="nav-link" href="/logout">Logout</a>
                    <?php else: ?>
                        <a class="nav-link" href="/login">Login</a>
                        <a class="nav-link" href="/register">Register</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <?= $_SESSION['success']; unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger">
                <?= $_SESSION['error']; unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <?= $content ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
