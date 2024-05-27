<h1>Welcome to <?php echo $_settings->info('name') ?> - Management Site</h1>
<hr>
<style>
  #site-cover {
    width: 100%;
    height: 40em;
    object-fit: cover;
    object-position: center center;
  }
</style>
<div class="row">
  <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
    <div class="info-box shadow-sm border rounded">
      <span class="info-box-icon bg-gradient-secondary"><i class="fas fa-th-list"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Categories</span>
        <span class="info-box-number">
          <?php
          $categorys = $conn->query("SELECT * FROM category_list where delete_flag = 0 ")->num_rows;
          echo format_num($categorys);
          ?>
          <?php ?>
        </span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->
  <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
    <div class="info-box shadow-sm border rounded">
      <span class="info-box-icon bg-gradient-success"><i class="fas fa-users"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Total Clients</span>
        <span class="info-box-number">
          <?php
          $clients = $conn->query("SELECT * FROM client_list where `delete_flag` = 0")->num_rows;
          echo format_num($clients);
          ?>
          <?php ?>
        </span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->
  <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
    <div class="info-box shadow-sm border rounded">
      <span class="info-box-icon bg-gradient-danger"><i class="fas fa-file-invoice"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Pending Bills</span>
        <span class="info-box-number">
          <?php
          $billings = $conn->query("SELECT * FROM billing_list where `status` = 0")->num_rows;
          echo format_num($billings);
          ?>
          <?php ?>
        </span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->
  <div class="mx-2 w-100 mt-2">
    <?php
    $currentYear = date('Y');

    // Construct the query to filter and sum by month
    $sql = "SELECT MONTH(date_created) AS month_num, 
        MONTHNAME(date_created) AS month_name, 
        SUM(total) AS total_billings 
        FROM billing_list 
        WHERE YEAR(date_created) = $currentYear 
        GROUP BY MONTH(date_created) 
        ORDER BY MONTH(date_created) ASC";

    // Execute the query
    $result = $conn->query($sql);

    // Check for errors (optional, but recommended)
    if ($result === false) {
      echo "Error fetching data: " . $conn->error;
      exit;
    }

    if ($result->num_rows > 0) {
      echo "<h4>Monthly Billing Totals for $currentYear</h4>";
      echo "<table class='table table-bordered shadow-sm bg-white'>";  // Add table structure (optional)
      echo "<thead>";  // Add table header (optional)
      echo "<tr>";
      echo "<th>Month</th>";
      echo "<th>Total Billings</th>";
      echo "</tr>";
      echo "</thead>";  // Add table header (optional)
      echo "<tbody>";  // Add table body (optional)

      // Loop through all months (1-12)
      for ($i = 1; $i <= 12; $i++) {
        $found = false;  // Flag to track if a record for this month exists
        while ($row = $result->fetch_assoc()) {
          if ($row['month_num'] == $i) {
            echo "<tr>";
            echo "<td>" . $row['month_name'] . "</td>";
            echo "<td>Php " . format_num($row['total_billings']) . "</td>";
            echo "</tr>";
            $found = true;
            break;  // Exit the inner loop after finding a record for this month
          }
        }
        // If no record found for this month, display zero
        if (!$found) {
          echo "<tr>";
          echo "<td>" . date('F', strtotime($currentYear . '-' . $i . '-01')) . "</td>";  // Month name from timestamp
          echo "<td>0.00</td>";
          echo "</tr>";
        }
        // Reset result pointer for the outer loop (optional, might not be necessary)
        $result->data_seek(0);  // Consider using if you encounter performance issues
      }

      echo "</tbody>";  // Add table body (optional)
      echo "</table>";  // Add table structure (optional)
    } else {
      echo "No billing records found for this year.";
    }
    ?>
  </div>
</div>
<!-- <hr> -->
<!-- <center>
  <img src="<?= validate_image($_settings->info('cover')) ?>" alt="<?= validate_image($_settings->info('logo')) ?>" id="site-cover" class="img-fluid w-100">
</center> -->