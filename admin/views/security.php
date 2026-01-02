<?php
$db = Database::getInstance()->getConnection();
$logs = $db->query("SELECT * FROM security_logs ORDER BY created_at DESC LIMIT 50")->fetchAll();
$attempts = $db->query("SELECT * FROM login_attempts ORDER BY last_attempt DESC")->fetchAll();

$pageTitle = 'Security Settings';
include __DIR__ . '/layout.php';
?>

<div class="security-container">
    <div class="section-header" style="margin-bottom: 24px;">
        <h2 style="font-size: 20px; font-weight: 600; color: #111827;">Security Overview</h2>
    </div>

    <div class="security-grid" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 40px;">
        <div class="security-card" style="padding: 24px; background: white; border: 1px solid #e5e7eb; border-radius: 12px; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
            <div style="display: flex; align-items: center; margin-bottom: 12px;">
                <div style="width: 8px; height: 8px; border-radius: 50%; background: #10b981; margin-right: 8px;"></div>
                <h4 style="font-size: 14px; font-weight: 500; color: #6b7280; margin: 0;">Brute-Force Protection</h4>
            </div>
            <p style="font-size: 24px; font-weight: 700; color: #059669; margin: 0;">Active</p>
        </div>

        <div class="security-card" style="padding: 24px; background: white; border: 1px solid #e5e7eb; border-radius: 12px; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
            <div style="display: flex; align-items: center; margin-bottom: 12px;">
                <div style="width: 8px; height: 8px; border-radius: 50%; background: #3b82f6; margin-right: 8px;"></div>
                <h4 style="font-size: 14px; font-weight: 500; color: #6b7280; margin: 0;">Session Hardening</h4>
            </div>
            <p style="font-size: 24px; font-weight: 700; color: #2563eb; margin: 0;">Enabled</p>
        </div>

        <div class="security-card" style="padding: 24px; background: white; border: 1px solid #e5e7eb; border-radius: 12px; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
            <div style="display: flex; align-items: center; margin-bottom: 12px;">
                <div style="width: 8px; height: 8px; border-radius: 50%; background: #f59e0b; margin-right: 8px;"></div>
                <h4 style="font-size: 14px; font-weight: 500; color: #6b7280; margin: 0;">Security Headers</h4>
            </div>
            <p style="font-size: 24px; font-weight: 700; color: #d97706; margin: 0;">Configured</p>
        </div>
    </div>

    <div class="security-section" style="background: white; border: 1px solid #e5e7eb; border-radius: 12px; overflow: hidden; margin-bottom: 32px;">
        <div style="padding: 20px 24px; border-bottom: 1px solid #e5e7eb;">
            <h3 style="font-size: 16px; font-weight: 600; color: #111827; margin-bottom: 4px;">Active Login Restrictions</h3>
            <p style="font-size: 13px; color: #6b7280; margin: 0;">IP addresses with multiple failed login attempts within the last 15 minutes.</p>
        </div>
        <div class="table-responsive">
            <table class="table" style="width: 100%; border-collapse: collapse;">
                <thead style="background: #f9fafb;">
                    <tr>
                        <th style="padding: 12px 24px; text-align: left; font-size: 12px; font-weight: 600; color: #4b5563; text-transform: uppercase; letter-spacing: 0.05em;">IP Address</th>
                        <th style="padding: 12px 24px; text-align: left; font-size: 12px; font-weight: 600; color: #4b5563; text-transform: uppercase; letter-spacing: 0.05em;">Attempts</th>
                        <th style="padding: 12px 24px; text-align: left; font-size: 12px; font-weight: 600; color: #4b5563; text-transform: uppercase; letter-spacing: 0.05em;">Last Attempt</th>
                        <th style="padding: 12px 24px; text-align: left; font-size: 12px; font-weight: 600; color: #4b5563; text-transform: uppercase; letter-spacing: 0.05em;">Status</th>
                    </tr>
                </thead>
                <tbody style="divide-y: 1px solid #e5e7eb;">
                    <?php if (empty($attempts)): ?>
                        <tr><td colspan="4" style="padding: 32px; text-align: center; color: #9ca3af; font-size: 14px;">No active restrictions</td></tr>
                    <?php else: ?>
                        <?php foreach ($attempts as $attempt): ?>
                            <tr style="border-top: 1px solid #e5e7eb;">
                                <td style="padding: 16px 24px; font-size: 14px; color: #111827; font-family: monospace;"><?= htmlspecialchars($attempt['ip_address']) ?></td>
                                <td style="padding: 16px 24px; font-size: 14px; color: #4b5563;"><?= $attempt['attempts'] ?>/5</td>
                                <td style="padding: 16px 24px; font-size: 14px; color: #4b5563;"><?= date('M j, Y H:i:s', strtotime($attempt['last_attempt'])) ?></td>
                                <td style="padding: 16px 24px;">
                                    <?php if ($attempt['attempts'] >= 5 && (time() - strtotime($attempt['last_attempt'])) < 900): ?>
                                        <span style="display: inline-flex; align-items: center; padding: 2px 8px; border-radius: 9999px; font-size: 12px; font-weight: 500; background: #fee2e2; color: #991b1b;">Blocked</span>
                                    <?php else: ?>
                                        <span style="display: inline-flex; align-items: center; padding: 2px 8px; border-radius: 9999px; font-size: 12px; font-weight: 500; background: #fef3c7; color: #92400e;">Warning</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="security-section" style="background: white; border: 1px solid #e5e7eb; border-radius: 12px; overflow: hidden;">
        <div style="padding: 20px 24px; border-bottom: 1px solid #e5e7eb;">
            <h3 style="font-size: 16px; font-weight: 600; color: #111827; margin: 0;">Recent Security Logs</h3>
        </div>
        <div class="table-responsive">
            <table class="table" style="width: 100%; border-collapse: collapse;">
                <thead style="background: #f9fafb;">
                    <tr>
                        <th style="padding: 12px 24px; text-align: left; font-size: 12px; font-weight: 600; color: #4b5563; text-transform: uppercase; letter-spacing: 0.05em;">Date</th>
                        <th style="padding: 12px 24px; text-align: left; font-size: 12px; font-weight: 600; color: #4b5563; text-transform: uppercase; letter-spacing: 0.05em;">Event</th>
                        <th style="padding: 12px 24px; text-align: left; font-size: 12px; font-weight: 600; color: #4b5563; text-transform: uppercase; letter-spacing: 0.05em;">IP Address</th>
                        <th style="padding: 12px 24px; text-align: left; font-size: 12px; font-weight: 600; color: #4b5563; text-transform: uppercase; letter-spacing: 0.05em;">Description</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($logs)): ?>
                        <tr><td colspan="4" style="padding: 32px; text-align: center; color: #9ca3af; font-size: 14px;">No logs recorded</td></tr>
                    <?php else: ?>
                        <?php foreach ($logs as $log): ?>
                            <tr style="border-top: 1px solid #e5e7eb;">
                                <td style="padding: 16px 24px; font-size: 13px; color: #6b7280; white-space: nowrap;"><?= date('M j, Y H:i:s', strtotime($log['created_at'])) ?></td>
                                <td style="padding: 16px 24px;">
                                    <span style="display: inline-flex; align-items: center; padding: 2px 8px; border-radius: 9999px; font-size: 11px; font-weight: 600; background: <?= $log['event_type'] === 'login_success' ? '#dcfce7' : '#fee2e2' ?>; color: <?= $log['event_type'] === 'login_success' ? '#166534' : '#991b1b' ?>; text-transform: uppercase;">
                                        <?= str_replace('_', ' ', htmlspecialchars($log['event_type'])) ?>
                                    </span>
                                </td>
                                <td style="padding: 16px 24px; font-size: 14px; color: #111827; font-family: monospace;"><?= htmlspecialchars($log['ip_address']) ?></td>
                                <td style="padding: 16px 24px; font-size: 14px; color: #4b5563;"><?= htmlspecialchars($log['description']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include __DIR__ . '/layout-end.php'; ?>