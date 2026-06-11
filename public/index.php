<?php
// public/index.php
require_once __DIR__ . '/../config/database.php';

$message = "";

// Check if form is clicked or submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Defensive Input Sanitization (Protects against basic scripting hacks)
    $soldier_id = htmlspecialchars(strip_tags(trim($_POST['soldier_id'])), ENT_QUOTES, 'UTF-8');
    
    if (isset($_POST['register_family'])) {
        $rank = htmlspecialchars($_POST['rank'], ENT_QUOTES, 'UTF-8');
        $division = htmlspecialchars($_POST['division'], ENT_QUOTES, 'UTF-8');
        $contact = htmlspecialchars($_POST['contact'], ENT_QUOTES, 'UTF-8');

        // Secure Prepared Statement insertion
        $stmt = $pdo->prepare("INSERT INTO beneficiaries (soldier_id, rank, division, contact_number) VALUES (?, ?, ?, ?)");
        $stmt->execute([$soldier_id, $rank, $division, $contact]);
        $message = "✅ Soldier Family Unit Registered Safely!";
    } 
    
    elseif (isset($_POST['allocate_aid'])) {
        $aid_type = htmlspecialchars($_POST['aid_type'], ENT_QUOTES, 'UTF-8');
        $amount = floatval($_POST['amount']);

        $stmt = $pdo->prepare("INSERT INTO disbursements (soldier_id, aid_type, amount) VALUES (?, ?, ?)");
        $stmt->execute([$soldier_id, $aid_type, $amount]);
        $message = "✅ Aid Record Disbursed Successfully!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>UPDF Welfare Portal</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>UPDF Family Welfare & Aid Registry</h1>
            <p>Official Intake & Allocation Management Dashboard</p>
            <a href="dashboard.php" style="color: yellow; text-decoration: none; font-weight: bold;">➡️ Go to Visual Analytics Dashboard</a>
        </header>

        <?php if($message): ?> <div class="card" style="color: green; font-weight: bold;"><?= $message ?></div> <?php endif; ?>

        <div class="card">
            <h2>1. Register New Dependent Family</h2>
            <form action="index.php" method="POST">
                <input type="text" name="soldier_id" placeholder="Soldier ID Number (e.g. UPDF-INF-102)" required>
                <input type="text" name="rank" placeholder="Soldier Rank (e.g. Captain)" required>
                <input type="text" name="division" placeholder="Military Division Assignment" required>
                <input type="text" name="contact" placeholder="Next of Kin Primary Mobile Contact" required>
                <button type="submit" name="register_family">Secure Register Record</button>
            </form>
        </div>

        <div class="card">
            <h2>2. Distribute Aid Support Ledger</h2>
            <form action="index.php" method="POST">
                <input type="text" name="soldier_id" placeholder="Target Soldier ID Number" required>
                <select name="aid_type">
                    <option value="School Bursary">School Bursary</option>
                    <option value="Medical Support">Medical Support</option>
                    <option value="Financial Relief">Financial Relief</option>
                </select>
                <input type="number" name="amount" placeholder="Amount allocated (UGX)" required>
                <button type="submit" name="allocate_aid">Log Disbursement</button>
            </form>
        </div>
    </div>
</body>
</html>