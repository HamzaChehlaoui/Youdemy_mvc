<div class="container">
    <h2>Student Dashboard</h2>
    
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Enrolled Courses</h5>
                    <h2 class="card-text"><?= $stats->enrolled_courses ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Completed Courses</h5>
                    <h2 class="card-text"><?= $stats->completed_courses ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">In Progress</h5>
                    <h2 class="card-text"><?= $stats->in_progress_courses ?></h2>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">Recent Activity</div>
        <div class="list-group list-group-flush">
            <?php foreach ($recentActivity as $activity): ?>
                <div class="list-group-item">
                    <h6 class="mb-1"><?= htmlspecialchars($activity->course_title) ?></h6>
                    <p class="mb-1"><?= htmlspecialchars($activity->activity_type) ?></p>
                    <small class="text-muted"><?= $activity->activity_date ?></small>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
