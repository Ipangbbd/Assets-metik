<?php
session_start();
require '../assets/backend/db.php';

// Handle delete request
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM asset WHERE id = ?");
    $stmt->execute([$id]);
    header('Location: assets.php');
    exit;
}

// Fetch all assets
$stmt = $conn->query("SELECT * FROM asset ORDER BY id DESC");
$assets = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assets Management</title>
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

<body class="hold-transition sidebar-mini">
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
                            <a href="dashboard.php" class="nav-link">
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
                            <a href="assets.php" class="nav-link active">
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
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Assets Management</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Assets</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Assets List</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addAssetModal">
                                            <i class="fas fa-plus"></i> Add New Asset
                                        </button>
                                    </div>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body table-responsive p-0">
                                    <table class="table table-hover text-nowrap">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Nama Asset</th>
                                                <th>Kategori</th>
                                                <th>Tanggal Pengadaan</th>
                                                <th>Harga</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $counter = 1;
                                            foreach ($assets as $asset):
                                            ?>
                                                <tr>
                                                    <td><?php echo $counter; $counter++; ?></td>
                                                    <td><?php echo htmlspecialchars($asset['nama_asset']); ?></td>
                                                    <td><?php echo htmlspecialchars($asset['kategori']); ?></td>
                                                    <td><?php echo htmlspecialchars($asset['tanggal_pengadaan']); ?></td>
                                                    <td><?php $harkha = htmlspecialchars($asset['harga']); $formatted_harkha = 'Rp ' . number_format($harkha, 0, ',', '.'); echo $formatted_harkha; ?></td>
                                                    <td>
                                                        <span class="badge <?php echo $asset['status'] == 'Active' ? 'bg-success' : 'bg-warning'; ?>">
                                                            <?php echo htmlspecialchars($asset['status']); ?>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#editAssetModal<?php echo $asset['id']; ?>">
                                                            <i class="fas fa-edit"></i> Edit
                                                        </button>
                                                        <a href="?delete=<?php echo $asset['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this asset?')">
                                                            <i class="fas fa-trash"></i> Delete
                                                        </a>
                                                    </td>
                                                </tr>

                                                <!-- Edit Asset -->
                                                <div class="modal fade" id="editAssetModal<?php echo $asset['id']; ?>">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <form action="api/Asset/update-asset.php" method="POST">
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title">Edit Asset</h4>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <input type="hidden" name="id" value="<?php echo $asset['id']; ?>" >
                                                                    <div class="form-group">
                                                                        <label for="nama_asset">Nama Asset</label>
                                                                        <input type="text" class="form-control" id="nama_asset" name="nama_asset" value="<?php echo htmlspecialchars($asset['nama_asset']); ?>" required>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="kategori">Kategori</label>
                                                                        <select class="form-control" id="kategori" name="kategori" required>
                                                                            <option value="Computer" <?php echo $asset['kategori'] == 'Computer' ? 'selected' : ''; ?>>Computer</option>
                                                                            <option value="Laptop" <?php echo $asset['kategori'] == 'Laptop' ? 'selected' : ''; ?>>Laptop</option>
                                                                            <option value="Phone" <?php echo $asset['kategori'] == 'Phone' ? 'selected' : ''; ?>>Phone</option>
                                                                            <option value="Printer" <?php echo $asset['Kategori'] == 'Printer' ? 'selected' : ''; ?>>Printer</option>
                                                                            <option value="Other" <?php echo $asset['Kategori'] == 'Other' ? 'selected' : ''; ?>>Other</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="tanggal_pengadaan">Tanggal Pengadaan</label>
                                                                        <input type="date" class="form-control" id="tanggal_pengadaan" name="tanggal_pengadaan" value="<?php echo htmlspecialchars($asset['tanggal_pengadaan']); ?>" required>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="harga">harga</label>
                                                                        <input type="number" class="form-control" id="harga" name="harga" value="<?php echo htmlspecialchars($asset['harga']); ?>" required>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="status">Status</label>
                                                                        <select class="form-control" id="status" name="status" required>
                                                                            <option value="Active" <?php echo $asset['status'] == 'Active' ? 'selected' : ''; ?>>Active</option>
                                                                            <option value="Inactive" <?php echo $asset['status'] == 'Inactive' ? 'selected' : ''; ?>>Inactive</option>
                                                                            <option value="Maintenance" <?php echo $asset['status'] == 'Maintenance' ? 'selected' : ''; ?>>Maintenance</option>
                                                                            <option value="Retired" <?php echo $asset['status'] == 'Retired' ? 'selected' : ''; ?>>Retired</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer justify-content-between">
                                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                        <!-- /.modal-content -->
                                                    </div>
                                                    <!-- /.modal-dialog -->
                                                </div>
                                                <!-- /.modal -->
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                    </div>
                    <!-- /.row -->
                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <footer class="main-footer">
            <div class="float-right d-none d-sm-block">
                <b>Version</b> 1.0.0
            </div>
            <strong>Copyright &copy; 2025</strong> All rights reserved.
        </footer>
    </div>
    <!-- ./wrapper -->

    <!-- Add Asset -->
    <div class="modal fade" id="addAssetModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="api/Asset/add-asset.php" method="POST">
                    <div class="modal-header">
                        <h4 class="modal-title">Add New Asset</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Nama Asset</label>
                            <input type="text" class="form-control" id="nama_asset" name="nama_asset" required>
                        </div>
                        <div class="form-group">
                            <label for="Kategori">Kategori</label>
                            <select class="form-control" id="Kategori" name="kategori" required>
                                <option value="Computer">Computer</option>
                                <option value="Laptop">Laptop</option>
                                <option value="Phone">Phone</option>
                                <option value="Printer">Printer</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="Tanggal Pengadaan">Tanggal Pengadaan</label>
                            <input type="date" class="form-control" id="tanggal_pengadaan" name="tanggal_pengadaan" required>
                        </div>
                        <div class="form-group">
                            <label for="harga">Harga</label>
                            <input type="number" class="form-control" id="harga" name="harga" required>
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                                <option value="Maintenance">Maintenance</option>
                                <option value="Retired">Retired</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Asset</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.1/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2.0/dist/js/adminlte.min.js"></script>
</body>

</html>