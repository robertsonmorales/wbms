<div class="print-client d-none">
    <table class="table table-hover table-striped table-bordered" id="client-list">
        <colgroup>
            <col width="5%">
            <col width="15%">
            <col width="25%">
            <col width="40%">
            <col width="15%">
        </colgroup>
        <thead>
            <tr>
                <th>#</th>
                <th>Date Created</th>
                <th>Code</th>
                <th>Name</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 1;
            $qry = $conn->query("SELECT *,concat(lastname, ', ', firstname, ' ', coalesce(middlename,'')) as `name` from `client_list` where delete_flag = 0 order by unix_timestamp(`date_created`) desc ");
            while ($rows = $qry->fetch_assoc()) :
            ?>
                <tr>
                    <td class="text-center"><?php echo $i++; ?></td>
                    <td><?php echo date("Y-m-d H:i", strtotime($rows['date_created'])) ?></td>
                    <td><?php echo $rows['code'] ?></td>
                    <td><?php echo $rows['name'] ?></td>
                    <td class="text-center">
                        <?php
                        switch ($rows['status']) {
                            case 1:
                                echo '<span class="badge badge-primary bg-gradient-primary text-sm px-3 rounded-pill">Active</span>';
                                break;
                            case 2:
                                echo '<span class="badge badge-danger bg-gradient-danger text-sm px-3 rounded-pill">Inactive</span>';
                                break;
                        }
                        ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>