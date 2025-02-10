<div class="container">
    <h2>Teacher Dashboard</h2>
    
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Active Courses</h5>
                    <h2 class="card-text"><?= $stats->active_courses ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Students</h5>
                    <h2 class="card-text"><?= $stats->total_students ?></h2>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">My Courses</h5>
            <a href="/courses/create" class="btn btn-primary">Add New Course</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Students</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($courses as $course): ?>
                            <tr>
                                <td><?= htmlspecialchars($course->title) ?></td>
                                <td><?= htmlspecialchars($course->category_name) ?></td>
                                <td><?= $course->student_count ?></td>
                                <td><?= htmlspecialchars($course->status) ?></td>
                                <td>
                                    <a href="/courses/edit/<?= $course->id_courses ?>" class="btn btn-sm btn-primary">Edit</a>
                                    <a href="/courses/delete/<?= $course->id_courses ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
