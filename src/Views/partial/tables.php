<?php
/**
 * Partial template for email tables
 * Used for both initial render and AJAX updates
 */
?>
<div class="email-tables">
    <!-- Valid Emails -->
    <div class="email-table">
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Emails : emails.txt</th>
                    </tr>
                </thead>
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
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Emails Non Valides : adressesNonValides.txt</th>
                    </tr>
                </thead>
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
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Emails Triés : emailsT.txt</th>
                    </tr>
                </thead>
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

<h2>Emails par Domaine</h2>
<!-- Domain Tables -->
<div class="domain-tables">
    <?php foreach ($domainEmails as $domain => $emails): ?>
        <div class="domain-table">
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th><?= htmlspecialchars($domain) ?></th>
                        </tr>
                    </thead>
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