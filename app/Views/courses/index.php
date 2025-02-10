<div class="row mb-4">
    <div class="col-md-8">
        <h2>Available Courses</h2>
    </div>
    <div class="col-md-4">
        <form method="GET" action="/courses">
            <div class="input-group">
                <input type="text" class="form-control" name="search" value="<?= htmlspecialchars($searchQuery) ?>" placeholder="Search courses...">
                <button class="btn btn-outline-secondary" type="submit">Search</button>
            </div>
        </form>
    </div>
</div>

<div class="row">
    <div class="col-md-3">
        <div class="card">
            <div class="card-header">Categories</div>
            <div class="list-group list-group-flush">
                <a href="/courses" class="list-group-item <?= !$categoryId ? 'active' : '' ?>">All Categories</a>
                <?php foreach ($categories as $category): ?>
                    <a href="/courses?category=<?= $category->id ?>" 
                       class="list-group-item <?= $categoryId == $category->id ? 'active' : '' ?>">
                        <?= htmlspecialchars($category->name) ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div class="col-md-9">
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php foreach ($courses as $course): ?>
                <div class="col">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($course->title) ?></h5>
                            <p class="card-text"><?= htmlspecialchars(substr($course->description, 0, 100)) ?>...</p>
                            <p class="card-text"><small class="text-muted">By <?= htmlspecialchars($course->teacher_name) ?></small></p>
                            <a href="/courses/<?= $course->id_courses ?>" class="btn btn-primary">View Course</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <?php if ($totalPages > 1): ?>
            <nav aria-label="Page navigation" class="mt-4">
                <ul class="pagination justify-content-center">
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <li class="page-item <?= $currentPage == $i ? 'active' : '' ?>">
                            <a class="page-link" href="/courses?page=<?= $i ?><?= $categoryId ? '&category='.$categoryId : '' ?><?= $searchQuery ? '&search='.urlencode($searchQuery) : '' ?>">
                                <?= $i ?>
                            </a>
                        </li>
                    <?php endfor; ?>
                </ul>
            </nav>
        <?php endif; ?>
    </div>
</div>
