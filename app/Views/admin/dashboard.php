<div class="container">
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Teachers</h5>
                    <h2 class="card-text"><?= $stats->total_teachers ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Students</h5>
                    <h2 class="card-text"><?= $stats->total_students ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Courses</h5>
                    <h2 class="card-text"><?= $stats->total_courses ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Pending Teachers</h5>
                    <h2 class="card-text"><?= $stats->pending_teachers ?></h2>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Recent Enrollments</div>
                <div class="card-body">
                    <div class="list-group">
                        <?php foreach ($recentEnrollments as $enrollment): ?>
                            <div class="list-group-item">
                                <h6 class="mb-1"><?= htmlspecialchars($enrollment->course_title) ?></h6>
                                <p class="mb-1">Student: <?= htmlspecialchars($enrollment->student_name) ?></p>
                                <small>Enrolled: <?= $enrollment->enrollment_date ?></small>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Popular Courses</div>
                <div class="card-body">
                    <div class="list-group">
                        <?php foreach ($popularCourses as $course): ?>
                            <div class="list-group-item">
                                <h6 class="mb-1"><?= htmlspecialchars($course->title) ?></h6>
                                <p class="mb-1">Teacher: <?= htmlspecialchars($course->teacher_name) ?></p>
                                <small>Students: <?= $course->student_count ?></small>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
