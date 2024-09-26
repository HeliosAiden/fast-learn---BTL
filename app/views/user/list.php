<h2 class="text-center mb-4">User Table</h2>
<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Role</th>
            <th>State</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (!empty($data['all_users'])) {
            // Output data of each row
            foreach ($data['all_users'] as $row) {
                echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['username']}</td>
                            <td>{$row['role']}</td>
                            <td>{$row['state']}</td>
                          </tr>";
            }
        } else {
            echo "<tr><td colspan='5' class='text-center'>No records found</td></tr>";
        }
        ?>
    </tbody>
</table>