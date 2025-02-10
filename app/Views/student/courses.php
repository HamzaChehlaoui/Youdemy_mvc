<div class="container">
    <h2>My Courses</h2>
    
    <ul class="nav nav-tabs mb-4">
        <li class="nav-item">
            <a class="nav-link <?= $currentTab === 'active' ? 'active' : '' ?>" href="?tab=active">Active Courses</a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= $currentTab === 'completed' ? 'active' : '' ?>" href="?tab=completed">Completed</a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= $currentTab === 'pending' ? 'active' : '' ?>" href="?tab=pending">Pending</a>
        </li>
    </ul>

    <div class="row row-cols-1 row-cols-md-3 g-4">
        <?php foreach (${$currentTab} as $course): ?>
            <div class="col">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($course->title) ?></h5>
                        <p class="card-text"><small class="text-muted">By <?= htmlspecialchars($course->teacher_name) ?></small></p>
                        <p class="card-text"><small class="text-muted">Category: <?= htmlspecialchars($course->category_name) ?></small></p>
                        <a href="/courses/<?= $course->id_courses ?>" class="btn btn-primary">Continue Learning</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
