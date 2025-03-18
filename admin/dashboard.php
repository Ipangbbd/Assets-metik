<?php
session_start();
require '../assets/backend/db.php';

// Fetch all assets
$stmt = $conn->query("SELECT * FROM asset ORDER BY id DESC");
$assets = $stmt->fetchAll(PDO::FETCH_ASSOC);

try {
    // count total assets
    $totalAssetsStmt = $conn->prepare("SELECT COUNT(*) as total FROM asset");
    $totalAssetsStmt->execute();
    $totalAssets = $totalAssetsStmt->fetch(PDO::FETCH_ASSOC)['total'];

    // sum all asset values
    $assetValueStmt = $conn->prepare("SELECT SUM(harga) as total_value FROM asset");
    $assetValueStmt->execute();
    $totalAssetValue = $assetValueStmt->fetch(PDO::FETCH_ASSOC)['total_value'];

    // count active users
    $activeUsersStmt = $conn->prepare("SELECT COUNT(*) as total FROM users");
    $activeUsersStmt->execute();
    $activeUsers = $activeUsersStmt->fetch(PDO::FETCH_ASSOC)['total'];

    // count assets needing maintenance
    $maintenanceStmt = $conn->prepare("SELECT COUNT(*) as total FROM asset WHERE status = 'maintenance'");
    $maintenanceStmt->execute();
    $maintenanceAssets = $maintenanceStmt->fetch(PDO::FETCH_ASSOC)['total'];

    // Format int to rp
    function formatRupiah($amount)
    {
        return "Rp " . number_format($amount, 0, ',', ',');
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- AdminLTE CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/css/adminlte.min.css" rel="stylesheet">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        .content-wrapper {
            min-height: 100vh;
        }

        .table-actions .btn {
            margin-right: 5px;
        }
    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-user"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-user-cog mr-2"></i> Profile
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="api/User/logout.php" class="dropdown-item">
                            <i class="fas fa-sign-out-alt mr-2"></i> Logout
                        </a>
                    </div>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="dashboard.php" class="brand-link">
                <i class="fas fa-cogs brand-image mt-1 ml-3"></i>
                <span class="brand-text font-weight-light">Admin Panel</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <i class="fas fa-user-circle img-circle elevation-2 text-light fa-2x"></i>
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">Admin User</a>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                        <!-- Dashboard -->
                        <li class="nav-item">
                            <a href="#" class="nav-link active">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        <!-- Users -->
                        <li class="nav-item">
                            <a href="users.php" class="nav-link">
                                <i class="nav-icon fas fa-users"></i>
                                <p>Users Management</p>
                            </a>
                        </li>
                        <!-- Assets -->
                        <li class="nav-item">
                            <a href="assets.php" class="nav-link">
                                <i class="nav-icon fas fa-laptop"></i>
                                <p>Assets Management</p>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Dashboard</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Dashboard</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <!-- Small boxes (Stat box) -->
                    <div class="row">
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h4><?php echo $totalAssets ?></h4>
                                    <p>Total Assets</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-box"></i>
                                </div>
                                <a href="assets.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h4><?php echo formatRupiah($totalAssetValue); ?></h4>
                                    <p>Total Asset Value</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-dollar-sign"></i>
                                </div>
                                <a href="assets.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    <h4><?php echo $activeUsers; ?></h4>
                                    <p>Active Users</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-users"></i>
                                </div>
                                <a href="users.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-danger">
                                <div class="inner">
                                    <h4><?php echo $maintenanceAssets; ?></h4>
                                    <p>Assets Need Maintenance</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-tools"></i>
                                </div>
                                <a href="assets.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->
                    </div>
                    <!-- /.row -->

                    <!-- Main row -->
                    <div class="row">
                        <!-- Left col -->
                        <section class="col-lg-7 connectedSortable">
                            <!-- Recent Assets -->
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Recently Added Assets</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body p-0">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Nama Asset</th>
                                                <th>Kategori</th>
                                                <th>T.Pengadaan</th>
                                                <th>Harga</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $latest_assets = array_slice($assets, -4, 4, true);
                                            foreach ($latest_assets as $asset):
                                            ?>
                                                <tr>
                                                    <td><?php echo $asset['id']; ?></td>
                                                    <td><?php echo htmlspecialchars($asset['nama_asset']); ?></td>
                                                    <td><?php echo htmlspecialchars($asset['kategori']); ?></td>
                                                    <td><?php echo htmlspecialchars($asset['tanggal_pengadaan']); ?></td>
                                                    <td style="font-size: 14px;"><?php $harkha = htmlspecialchars($asset['harga']); $formatted_harkha = 'Rp ' . number_format($harkha, 0, ',', '.'); echo $formatted_harkha; ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer clearfix">
                                    <a href="assets.php" class="btn btn-sm btn-info float-right">View All Assets</a>
                                </div>
                            </div>
                            <!-- /.card -->
                        </section>
                        <!-- /.Left col -->

                        <?php
                        // get asset categories and count
                        $query = "SELECT kategori, COUNT(*) as count FROM asset GROUP BY kategori ORDER BY count DESC";
                        $stmt = $conn->prepare($query);
                        $stmt->execute();
                        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        // Calculate total assets for percentage calculatiom
                        $totalAssets = 0;
                        foreach ($categories as $category) {
                            $totalAssets += $category['count'];
                        }

                        // Prepare category data with percentages
                        $categoryData = [];
                        $otherCount = 0;

                        // Get top 5 categories, combine the rest as Others
                        foreach ($categories as $index => $category) {
                            if ($index < 5) {
                                $categoryData[] = [
                                    'name' => $category['kategori'],
                                    'count' => $category['count'],
                                    'percentage' => ($category['count'] / $totalAssets) * 100
                                ];
                            } else {
                                $otherCount += $category['count'];
                            }
                        }

                        // Add Others category if there are more than 5 categories
                        if ($otherCount > 0) {
                            $categoryData[] = [
                                'name' => 'Others',
                                'count' => $otherCount,
                                'percentage' => ($otherCount / $totalAssets) * 100
                            ];
                        }

                        // get assets with syatus "Maintenance" ordered by closest dates
                        $maintenanceQuery = "SELECT id, nama_asset, kategori, tanggal_pengadaan, status FROM asset WHERE status = 'Maintenance' ORDER BY tanggal_pengadaan ASC LIMIT 3";
                        $maintenanceStmt = $conn->prepare($maintenanceQuery);
                        $maintenanceStmt->execute();
                        $maintenanceItems = $maintenanceStmt->fetchAll(PDO::FETCH_ASSOC);

                        // calculate days remaining (using tanggal_pengadaan as example)
                        function getDaysRemaining($date)
                        {
                            $today = new DateTime();
                            $maintenanceDate = new DateTime($date);
                            $interval = $today->diff($maintenanceDate);
                            return $interval->days;
                        }

                        // Function to get an appprpriate text color class based on days remaining
                        function getColorClass($days)
                        {
                            if ($days <= 3) {
                                return 'text-danger';
                            } elseif ($days <= 7) {
                                return 'text-warning';
                            } else {
                                return 'text-info';
                            }
                        }
                        ?>

                        <!-- Right col -->
                        <section class="col-lg-5 connectedSortable">
                            <div class="card">
                                <!-- /.card-header -->
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <i class="fas fa-chart-pie mr-1"></i>
                                        Asset Categroies
                                    </h3>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer bg-light p-0">
                                    <ul class="nav nav-pills flex-column">
                                        <?php foreach ($categoryData as $data): ?>
                                            <li class="nav-item">
                                                <a href="assets.php?kategori=<?= urlencode($data['name']) ?>" class="nav-link">
                                                    <?= htmlspecialchars($data['name']) ?>
                                                    <span class="float-right text-primary"><?= number_format($data['percentage'], 1) ?>%</span>
                                                </a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>
                            <!-- /.card -->

                            <!-- Asset Maintenance Calendar Card -->
                            <div class="card">
                                <div class="card-header border-0">
                                    <h3 class="card-title">Upcoming Maintenance</h3>
                                </div>
                                <div class="card-body pt-0">
                                    <div class="list-group">
                                        <?php if (count($maintenanceItems) > 0): ?>
                                            <?php foreach ($maintenanceItems as $item):
                                                $daysRemaining = getDaysRemaining($item['tanggal_pengadaan']);
                                                $colorClass = getColorClass($daysRemaining);
                                            ?>
                                                <a href="assets.php?id=<?= $item['id'] ?>" class="list-group-item list-group-item-action flex-column align-items-start">
                                                    <div class="d-flex w-100 justify-content-between">
                                                        <h5 class="mb-1"><?= htmlspecialchars($item['nama_asset']) ?></h5>
                                                        <small class="<?= $colorClass ?>"><?= $daysRemaining ?> days</small>
                                                    </div>
                                                    <p class="mb-1">Scheduled maintenance for <?= htmlspecialchars($item['kategori']) ?> asset.</p>
                                                    <small>ID: A<?= $item['id'] ?> | Status: <?= $item['status'] ?></small>
                                                </a>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <div class="alert alert-info">
                                                No maintenance scheduled at this time.
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="card-footer text-center">
                                    <a href="assets.php">View All Scheduled Maintenance</a>
                                </div>
                            </div>
                            <!-- /.card -->
                        </section>
            </section>
            <!-- right col -->
        </div>
        <!-- /.row (main row) -->
        
    </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <footer class="main-footer">
        <strong>Copyright &copy; 2025.</strong>
        All rights reserved.
        <div class="float-right d-none d-sm-inline-block">
            <b>Version</b> 1.0.0
        </div>
    </footer>
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.1/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/js/adminlte.min.js"></script>
</body>

</html>