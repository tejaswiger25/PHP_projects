<?php
include 'db.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ticket_number = "SR" . rand(100000000, 999999999);
    $stmt = $conn->prepare(
        "INSERT INTO tickets (ticket_number, request_type, pnr, passenger_name, flight_no, change_date, remarks)
         VALUES (?,?,?,?,?,?,?)"
    );
    $stmt->bind_param(
        "sssssss",
        $ticket_number,
        $_POST['request_type'],
        $_POST['pnr'],
        $_POST['passenger'],
        $_POST['flight'],
        $_POST['change_date'],
        $_POST['remarks']
    );
    $stmt->execute();
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Support Ticket System</title>
<link rel="stylesheet" href="assets/css/style.css">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

<div class="app">
<aside class="sidebar">
<h2>TripSupport</h2>
<a class="active">Support Ticket</a>
<a>Dashboard</a>
<a>Bookings</a>
<a>Payments</a>
</aside>

<main class="main">
<div class="card">
<h3>Create New Ticket</h3>
<form method="post">
<select name="request_type">
<option>Reissue Request</option>
<option>Refund Request</option>
<option>VIP Request</option>
</select>
<input name="pnr" placeholder="PNR" required>
<input name="passenger" placeholder="Passenger Name" required>
<input name="flight" placeholder="Flight No" required>
<input type="date" name="change_date">
<textarea name="remarks" placeholder="Remarks"></textarea>
<button>Submit Ticket</button>
</form>
</div>

<div class="card">
<h3>Latest Support History</h3>
<?php
$result = $conn->query("SELECT * FROM tickets ORDER BY created_at DESC LIMIT 5");
while($row = $result->fetch_assoc()){
echo "<div class='row'><b>#{$row['ticket_number']}</b> {$row['request_type']} <span>{$row['status']}</span></div>";
}
?>
</div>
</main>
</div>

</body>
</html>