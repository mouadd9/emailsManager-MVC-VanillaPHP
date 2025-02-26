<?php
/**
 * Partial template for email tables
 * Used for both initial render and AJAX updates
 */
?>
<div class="email-tables">
    <!-- Valid Emails -->
    <div class="email-table">
        <div class="table-header">
            <h3>Emails : Emails.txt</h3>
            <button class="export-btn" data-type="valid">
                <i class="fas fa-download"></i> Exporter
            </button>
        </div>
        <div class="table-container">
            <table>
                <tbody>
                    <?php foreach ($validEmails as $email): ?>
                        <tr>
                            <td><?= htmlspecialchars($email) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Invalid Emails -->
    <div class="email-table">
        <div class="table-header">
            <h3>Emails Non Valides : adressesNonValides.txt</h3>
            <button class="export-btn" data-type="invalid">
                <i class="fas fa-download"></i> Exporter
            </button>
        </div>
        <div class="table-container">
            <table>
                <tbody>
                    <?php foreach ($invalidEmails as $email): ?>
                        <tr>
                            <td><?= htmlspecialchars($email) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Sorted Emails -->
    <div class="email-table">
        <div class="table-header">
            <h3>Emails Triés : EmailsT.txt</h3>
            <button class="export-btn" data-type="sorted">
                <i class="fas fa-download"></i> Exporter
            </button>
        </div>
        <div class="table-container">
            <table>
                <tbody>
                    <?php foreach ($sortedEmails as $email): ?>
                        <tr>
                            <td><?= htmlspecialchars($email) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Domain Tables -->
<?php if (!empty($domainEmails)): ?>
    <h2>Emails par Domaine</h2>
    <div class="domain-tables">
        <?php foreach ($domainEmails as $domain => $emails): ?>

            <div class="domain-table">
                <div class="table-header">
                    <h3><?= htmlspecialchars($domain) ?></h3>
                    <button class="export-btn" data-type="domain" data-domain="<?= htmlspecialchars($domain) ?>">
                        <i class="fas fa-download"></i> Exporter
                    </button>
                </div>
                <div class="table-container">
                    <table>
                        <tbody>
                            <?php foreach ($emails as $email): ?>
                                <tr>
                                    <td><?= htmlspecialchars($email) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>