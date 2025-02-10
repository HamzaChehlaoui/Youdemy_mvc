<div class="container">
    <div class="row">
        <div class="col-md-8">
            <h1><?= htmlspecialchars($course->title) ?></h1>
            <div class="card mb-4">
                <div class="card-body">
                    <h5>Description</h5>
                    <p><?= htmlspecialchars($course->description) ?></p>
                    <div class="mt-3">
                        <strong>Category:</strong> <?= htmlspecialchars($course->category_name) ?><br>
                        <strong>Instructor:</strong> <?= htmlspecialchars($course->teacher_name) ?>
                    </div>
                </div>
            </div>
            
            <?php if (isset($_SESSION['user_id']) && $_SESSION['role'] === 'student'): ?>
                <form method="POST" action="/enroll">
                    <input type="hidden" name="course_id" value="<?= $course->id_courses ?>">
                    <button type="submit" class="btn btn-primary">Enroll Now</button>
                </form>
            <?php endif; ?>
        </div>
    </div>
</div>
