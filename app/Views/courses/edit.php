<div class="container">
    <h2>Edit Course</h2>
    <div class="card">
        <div class="card-body">
            <form method="POST" action="/courses/update/<?= $course->id_courses ?>">
                <div class="mb-3">
                    <label for="title" class="form-label">Course Title</label>
                    <input type="text" class="form-control" id="title" name="title" value="<?= htmlspecialchars($course->title) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3" required><?= htmlspecialchars($course->description) ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="category" class="form-label">Category</label>
                    <select class="form-control" id="category" name="category" required>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= $category->id ?>" <?= $category->id == $course->category_id ? 'selected' : '' ?>>
                                <?= htmlspecialchars($category->name) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="content_url" class="form-label">Content URL</label>
                    <input type="url" class="form-control" id="content_url" name="content_url" value="<?= htmlspecialchars($course->content_url) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="tags" class="form-label">Tags (comma separated)</label>
                    <input type="text" class="form-control" id="tags" name="tags" value="<?= htmlspecialchars($courseTags) ?>">
                </div>
                <button type="submit" class="btn btn-primary">Update Course</button>
            </form>
        </div>
    </div>
</div>
