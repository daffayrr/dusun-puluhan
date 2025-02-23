<?php
require '../assets/auth.php';
require '../Database/config.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Backup & Restore</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/plugins/fontawesome-free/css/all.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
    <?php include '../assets/header.php'; ?>
    <?php include '../assets/sidebar.php'; ?>

    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Backup & Restore</h1>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card card-primary">
                            <div class="card-header"><h3 class="card-title">Backup Database</h3></div>
                            <div class="card-body text-center">
                                <button class="btn btn-primary" data-toggle="modal" data-target="#backupModal"><i class="fas fa-download"></i> Backup</button>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card card-success">
                            <div class="card-header"><h3 class="card-title">Restore Database</h3></div>
                            <div class="card-body text-center">
                                <button class="btn btn-success" data-toggle="modal" data-target="#restoreModal"><i class="fas fa-upload"></i> Restore</button>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card card-danger">
                            <div class="card-header"><h3 class="card-title">Hapus Semua Data</h3></div>
                            <div class="card-body text-center">
                                <button class="btn btn-danger" data-toggle="modal" data-target="#clearModal"><i class="fas fa-trash"></i> Clear Data</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="progress" id="progressBarContainer" style="display:none;">
                    <div id="progressBar" class="progress-bar progress-bar-striped progress-bar-animated" style="width: 0%">0%</div>
                </div>
            </div>
        </section>
    </div>

    <footer class="main-footer">
        <strong>Copyright &copy; 2025 Dusun Puluhan.</strong> All rights reserved.
    </footer>
</div>

<!-- MODALS -->
<div class="modal fade" id="backupModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"><h4 class="modal-title">Konfirmasi Backup</h4></div>
            <div class="modal-body">Apakah Anda yakin ingin melakukan backup database?</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="startBackup">Ya, Backup</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="restoreModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"><h4 class="modal-title">Konfirmasi Restore</h4></div>
            <div class="modal-body">Pilih file backup untuk merestore database.</div>
            <div class="modal-footer">
                <input type="file" id="backupFile" class="form-control">
                <button type="button" class="btn btn-success" id="startRestore">Restore</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="clearModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"><h4 class="modal-title">Konfirmasi Hapus Data</h4></div>
            <div class="modal-body">Apakah Anda yakin ingin menghapus semua data?</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger" id="startClear">Ya, Hapus</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/plugins/jquery/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

<script>
function updateProgress(value) {
    $('#progressBar').css('width', value + '%').text(value + '%');
}

$('#startBackup').click(function() {
    $('#backupModal').modal('hide');
    $('#progressBarContainer').show();
    updateProgress(10);
    
    $.post('backup_process.php', function(response) {
        updateProgress(100);
        alert(response);
    });
});

$('#startRestore').click(function() {
    let file = $('#backupFile')[0].files[0];
    if (!file) { alert('Pilih file backup terlebih dahulu!'); return; }
    
    let formData = new FormData();
    formData.append('file', file);
    
    $('#restoreModal').modal('hide');
    $('#progressBarContainer').show();
    updateProgress(10);
    
    $.ajax({
        url: 'restore_process.php',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            updateProgress(100);
            alert(response);
        }
    });
});

$('#startClear').click(function() {
    $('#clearModal').modal('hide');
    $('#progressBarContainer').show();
    updateProgress(10);
    
    $.post('clear_process.php', function(response) {
        updateProgress(100);
        alert(response);
    });
});
</script>
</body>
</html>
