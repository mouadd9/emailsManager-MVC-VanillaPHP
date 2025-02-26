<?php if (!empty($frequencies)): ?>
    <div class="email-table">
        <div class="table-header">
            <h3>Fréquence des Emails</h3>
            <button class="export-btn" data-type="frequency">
                <i class="fas fa-download"></i> Exporter
            </button>
        </div>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Email</th>
                        <th>Occurrences</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($frequencies as $email => $count): ?>
                        <tr>
                            <td><?= htmlspecialchars($email) ?></td>
                            <td><?= $count ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php endif; ?>
