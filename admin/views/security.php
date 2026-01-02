<?php
$db = Database::getInstance()->getConnection();
$logs = $db->query("SELECT * FROM security_logs ORDER BY created_at DESC LIMIT 50")->fetchAll();
$attempts = $db->query("SELECT * FROM login_attempts ORDER BY last_attempt DESC")->fetchAll();

$pageTitle = 'Security Settings';
include __DIR__ . '/layout.php';
?>

<div class="card">
    <div class="card-header">
        <h2>Security Overview</h2>
    </div>
    <div class="card-content">
        <div class="security-status" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px;">
            <div class="status-item" style="padding: 20px; background: #f8f9fa; border-radius: 8px; border-left: 4px solid #28a745;">
                <h4 style="margin-bottom: 5px;">Brute-Force Protection</h4>
                <p style="color: #28a745; font-weight: 600;">Active</p>
            </div>
            <div class="status-item" style="padding: 20px; background: #f8f9fa; border-radius: 8px; border-left: 4px solid #007bff;">
                <h4 style="margin-bottom: 5px;">Session Hardening</h4>
                <p style="color: #007bff; font-weight: 600;">Enabled</p>
            </div>
            <div class="status-item" style="padding: 20px; background: #f8f9fa; border-radius: 8px; border-left: 4px solid #ffc107;">
                <h4 style="margin-bottom: 5px;">Security Headers</h4>
                <p style="color: #ffc107; font-weight: 600;">Configured</p>
            </div>
        </div>

        <h3>Active Login Restrictions</h3>
        <p class="text-secondary" style="margin-bottom: 15px;">IP addresses with multiple failed login attempts within the last 15 minutes.</p>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>IP Address</th>
                        <th>Attempts</th>
                        <th>Last Attempt</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($attempts)): ?>
                        <tr><td colspan="4" class="text-center">No active restrictions</td></tr>
                    <?php else: ?>
                        <?php foreach ($attempts as $attempt): ?>
                            <tr>
                                <td><?= htmlspecialchars($attempt['ip_address']) ?></td>
                                <td><?= $attempt['attempts'] ?>/5</td>
                                <td><?= $attempt['last_attempt'] ?></td>
                                <td>
                                    <?php if ($attempt['attempts'] >= 5 && (time() - strtotime($attempt['last_attempt'])) < 900): ?>
                                        <span class="badge danger" style="background: #dc3545; color: white; padding: 4px 8px; border-radius: 4px; font-size: 12px;">Blocked</span>
                                    <?php else: ?>
                                        <span class="badge warning" style="background: #ffc107; color: black; padding: 4px 8px; border-radius: 4px; font-size: 12px;">Warning</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <h3 style="margin-top: 40px;">Recent Security Logs</h3>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Event</th>
                        <th>IP Address</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($logs as $log): ?>
                        <tr>
                            <td><?= $log['created_at'] ?></td>
                            <td>
                                <span class="badge" style="background: <?= $log['event_type'] === 'login_success' ? '#28a745' : '#dc3545' ?>; color: white; padding: 4px 8px; border-radius: 4px; font-size: 11px;">
                                    <?= htmlspecialchars($log['event_type']) ?>
                                </span>
                            </td>
                            <td><?= htmlspecialchars($log['ip_address']) ?></td>
                            <td><?= htmlspecialchars($log['description']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include __DIR__ . '/layout-end.php'; ?>