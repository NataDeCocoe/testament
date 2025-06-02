<form action="/notifications/send" method="POST" enctype="multipart/form-data"
      style="max-width:800px; margin:20px auto; background: transparent; padding:30px; border-radius:12px;">
    <h2 style="margin-top:0; color:#2c3e50; border-bottom:1px solid #eee; padding-bottom:15px; margin-bottom:25px;">Create Notification</h2>

    <div style="display:grid; grid-template-columns:1fr 1fr; gap:30px;">
        <div style="display:flex; flex-direction:column;">
            <div style="margin-bottom:20px;">
                <label style="display:block; margin-bottom:8px; font-weight:600; color:#34495e;">Title</label>
                <input type="text" name="title" required placeholder="Enter notification title"
                       style="width:100%; padding:12px; border:1px solid #ddd; border-radius:6px; font-size:14px;">
            </div>

            <div style="margin-bottom:20px;">
                <label style="display:block; margin-bottom:8px; font-weight:600; color:#34495e;">Select User</label>
                <select name="user_id" required
                        style="width:100%; padding:12px; border:1px solid #ddd; border-radius:6px; font-size:14px;">
                    <option value="" disabled selected>Select a user</option>
                    <?php foreach ($users as $user): ?>
                        <option value="<?= htmlspecialchars($user['id']) ?>">
                            <?= htmlspecialchars($user['fullname']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

        </div>

        <div style="margin-bottom:20px;">
            <label style="display:block; margin-bottom:8px; font-weight:600; color:#34495e;">Image (optional)</label>
            <input type="file" name="img" accept="image/*"
                   style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px; font-size:14px;">
            <p style="margin-top:8px; font-size:12px; color:#7f8c8d;">Max size: 2MB. Supported formats: JPG, PNG, GIF</p>
        </div>
    </div>

    <div style="margin-bottom:25px;">
        <label style="display:block; margin-bottom:8px; font-weight:600; color:#34495e;">Message</label>
        <textarea name="message" rows="5" required placeholder="Enter notification message"
                  style="width:100%; padding:12px; border:1px solid #ddd; border-radius:6px; font-size:14px; resize:vertical;"></textarea>
    </div>

    <button type="submit"
            style="width:200px; padding:14px; background:#fcd34d; color:white; border:none; border-radius:6px; font-size:16px; font-weight:600; cursor:pointer; transition:background 0.3s; margin-left:auto;">
        Send Notification
    </button>
</form>
