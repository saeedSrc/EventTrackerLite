<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filtered Results</title>
</head>
<body>
<h2>Filtered Results</h2>

<?php if (count($filteredResults) > 0): ?>
    <table border="1">
        <thead>
        <tr>
            <th>Employee Name</th>
            <th>Event Name</th>
            <th>Event Date</th>
            <th>Participation Fee</th>
            <th>Version</th>
            <!-- Add other columns as needed -->
        </tr>
        </thead>
        <tbody>
        <?php foreach ($filteredResults as $result): ?>
            <tr>
                <td><?= $result['employee_name'] ?></td>
                <td><?= $result['event_name'] ?></td>
                <td><?= $result['event_date'] ?></td>
                <td><?= $result['participation_fee'] ?></td>
                <td><?= $result['version'] ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>No results found.</p>
<?php endif; ?>

<?php if (count($filteredResults) > 0): ?>
<!-- Calculate the total price -->
<?php $totalPrice = array_sum(array_column($filteredResults, 'participation_fee')); ?>

<table border="1">
    <tfoot>
    <tr>
        <td colspan="3"></td>
        <td>Total Price:</td>
        <td><?= number_format($totalPrice, 2) ?></td>
    </tr>
    </tfoot>
</table>
<?php endif; ?>

</body>
</html>
