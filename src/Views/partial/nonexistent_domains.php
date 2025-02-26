<?php if (!empty($nonexistentDomains)): ?>
    <div class="email-table">
        <div class="table-header">
            <h3>Domaines Non Existants</h3>
            <button class="export-btn" data-type="nonexistent">
                <i class="fas fa-download"></i> Exporter
            </button>
        </div>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Domaine</th>
                        <th>Emails Affectés</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($nonexistentDomains as $domain => $emails): ?>
                        <tr>
                            <td><?= htmlspecialchars($domain) ?></td>
                            <td>
                                <?php foreach ($emails as $email): ?>
                                    <div><?= htmlspecialchars($email) ?></div>
                                <?php endforeach; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php endif; ?>
