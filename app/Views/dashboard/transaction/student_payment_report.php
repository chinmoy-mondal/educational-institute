<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Sender</th>
            <th>Receiver</th>
            <th>Month</th>
            <th>Total Pay</th>
            <th>Total Discount</th>
            <th>Net Amount</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($report as $row): ?>
        <tr>
            <td><?= esc($row['sender_name']) ?></td>
            <td><?= esc($row['receiver_name']) ?></td>
            <td><?= esc($row['month']) ?></td>
            <td><?= number_format($row['total_pay'], 2) ?></td>
            <td><?= number_format($row['total_discount'], 2) ?></td>
            <td><?= number_format($row['net_amount'], 2) ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>