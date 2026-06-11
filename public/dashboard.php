<?php
// public/dashboard.php
require_once __DIR__ . '/../config/database.php';

// Optimization: Single Query execution prevents loops and N+1 performance lag traps!
$stmt = $pdo->query("SELECT * FROM beneficiaries");
$families = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welfare Analytics Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="container">
        <header>
            <h1>Welfare Performance & Analytics</h1>
            <a href="index.php" style="color: #fff;">⬅️ Return to Entry Forms Portal</a>
        </header>

        <div class="card">
            <h2>Visual Fund Allocations Framework (UGX)</h2>
            <div style="max-width: 600px; margin: 0 auto;">
                <canvas id="welfareChart"></canvas>
            </div>
        </div>

        <div class="card">
            <h2>Onboarded Dependents Database Index</h2>
            <table>
                <thead>
                    <tr>
                        <th>Soldier ID</th>
                        <th>Rank</th>
                        <th>Division Location</th>
                        <th>Contact Number</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($families as $f): ?>
                    <tr>
                        <td><?= htmlspecialchars($f['soldier_id'], ENT_QUOTES) ?></td>
                        <td><?= htmlspecialchars($f['rank'], ENT_QUOTES) ?></td>
                        <td><?= htmlspecialchars($f['division'], ENT_QUOTES) ?></td>
                        <td><?= htmlspecialchars($f['contact_number'], ENT_QUOTES) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        // Use Fetch to gather JSON data smoothly behind the scenes
        fetch('get-data.php')
            .then(response => response.json())
            .then(serverData => {
                // Break down data into names and matching dollar values
                const labels = serverData.map(row => row.aid_type);
                const values = serverData.map(row => row.total_amount);

                // Initialize the Chart frame element
                const ctx = document.getElementById('welfareChart').getContext('2d');
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Total Allocation Metrics',
                            data: values,
                            backgroundColor: ['#1b4332', '#40916c', '#52b788']
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: { y: { beginAtZero: true } }
                    }
                });
            });
    </script>
</body>
</html>