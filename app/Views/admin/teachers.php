<div class="container">
    <h2>Manage Teachers</h2>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Courses</th>
                    <th>Students</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($teacher = $teachers->fetch(PDO::FETCH_OBJ)): ?>
                    <tr>
                        <td><?= htmlspecialchars($teacher->username) ?></td>
                        <td><?= htmlspecialchars($teacher->email) ?></td>
                        <td><?= $teacher->course_count ?></td>
                        <td><?= $teacher->student_count ?></td>
                        <td><?= htmlspecialchars($teacher->status) ?></td>
                        <td>
                            <form method="POST" style="display: inline">
                                <input type="hidden" name="user_id" value="<?= $teacher->id_user ?>">
                                <?php if ($teacher->status === 'pending'): ?>
                                    <button type="submit" name="action" value="activate" class="btn btn-sm btn-success">Approve</button>
                                <?php else: ?>
                                    <button type="submit" name="action" value="suspend" class="btn btn-sm btn-warning">Suspend</button>
                                <?php endif; ?>
                                <button type="submit" name="action" value="delete" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>
