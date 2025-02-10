<div class="container">
    <h2>Create New Course</h2>
    <div class="card">
        <div class="card-body">
            <form method="POST" action="/courses/store">
                <div class="mb-3">
                    <label for="title" class="form-label">Course Title</label>
                    <input type="text" class="form-control" id="title" name="title" required>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="category" class="form-label">Category</label>
                    <select class="form-control" id="category" name="category" required>
                        <option value="">Select Category</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= $category->id ?>"><?= htmlspecialchars($category->name) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="content_type" class="form-label">Content Type</label>
                    <select class="form-control" id="content_type" name="content_type" required>
                        <option value="video">Video</option>
                        <option value="document">Document</option>
                    </select>
                </div>
                <div id="video_url_group" class="mb-3">
                    <label for="video_url" class="form-label">Video URL</label>
                    <input type="url" class="form-control" id="video_url" name="video_url">
                </div>
                <div id="document_url_group" class="mb-3" style="display:none;">
                    <label for="document_url" class="form-label">Document URL</label>
                    <input type="url" class="form-control" id="document_url" name="document_url">
                </div>
                <div class="mb-3">
                    <label for="tags" class="form-label">Tags (comma separated)</label>
                    <input type="text" class="form-control" id="tags" name="tags">
                </div>
                <button type="submit" class="btn btn-primary">Create Course</button>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('content_type').addEventListener('change', function() {
    const videoGroup = document.getElementById('video_url_group');
    const documentGroup = document.getElementById('document_url_group');
    if (this.value === 'video') {
        videoGroup.style.display = 'block';
        documentGroup.style.display = 'none';
    } else {
        videoGroup.style.display = 'none';
        documentGroup.style.display = 'block';
    }
});
</script>
