<?php
include 'koneksi.php';

// Fitur Simpan & Update Pasien
if (isset($_POST['simpan_pasien'])) {
    $id_pasien = $_POST['id_pasien'];
    $no_rm = $_POST['no_rm'];
    $nama_pasien = $_POST['nama_pasien'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $alamat = $_POST['alamat'];

    if ($id_pasien == "") {
        $query = "INSERT INTO pasien VALUES (NULL, '$no_rm', '$nama_pasien', '$jenis_kelamin', '$tanggal_lahir', '$alamat')";
    } else {
        $query = "UPDATE pasien SET no_rm='$no_rm', nama_pasien='$nama_pasien', jenis_kelamin='$jenis_kelamin', tanggal_lahir='$tanggal_lahir', alamat='$alamat' WHERE id_pasien='$id_pasien'";
    }
    mysqli_query($koneksi, $query);
    header("Location: pasien.php");
}

// Fitur Hapus Pasien
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($koneksi, "DELETE FROM pasien WHERE id_pasien='$id'");
    header("Location: pasien.php");
}

include 'header.php';
?>

<div class="card-aesthetic p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1" style="color: #0284c7;">
                <i class="fa-solid fa-user-injured me-2"></i>Data Pasien
            </h4>
            <p class="text-muted small mb-0">Kelola master informasi data pasien Rumah Sakit.</p>
        </div>
        <button class="btn btn-primary rounded-pill px-4 py-2 fw-semibold shadow-sm" data-bs-toggle="modal" data-bs-target="#modalPasien" onclick="resetForm()" style="background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%); border: none;">
            <i class="fa-solid fa-plus me-2"></i>Tambah Pasien
        </button>
    </div>

    <div class="table-responsive">
        <table class="table-rs">
            <thead>
                <tr>
                    <th style="width: 50px;">NO</th>
                    <th>NO. RM</th>
                    <th>NAMA PASIEN</th>
                    <th>JENIS KELAMIN</th>
                    <th class="text-nowrap">TANGGAL LAHIR</th>
                    <th>ALAMAT</th>
                    <th class="text-center text-nowrap" style="width: 120px;">AKSI</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                $data = mysqli_query($koneksi, "SELECT * FROM pasien ORDER BY id_pasien DESC");
                while ($row = mysqli_fetch_assoc($data)) {
                ?>
                <tr>
                    <td class="fw-bold text-muted text-center"><?= $no++; ?></td>
                    <td class="text-nowrap">
                        <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill font-monospace fw-bold">
                            <?= $row['no_rm']; ?>
                        </span>
                    </td>
                    <td><strong class="text-dark"><?= $row['nama_pasien']; ?></strong></td>
                    <td class="text-nowrap">
                        <?php if ($row['jenis_kelamin'] == 'L') { ?>
                            <span class="badge bg-info bg-opacity-10 text-info px-3 py-2 rounded-pill fw-semibold">
                                <i class="fa-solid fa-mars me-1"></i> Laki-laki
                            </span>
                        <?php } else { ?>
                            <span class="badge bg-danger bg-opacity-10 text-danger px-3 py-2 rounded-pill fw-semibold">
                                <i class="fa-solid fa-venus me-1"></i> Perempuan
                            </span>
                        <?php } ?>
                    </td>
                    <td class="text-nowrap">
                        <span class="text-secondary fw-medium">
                            <i class="fa-regular fa-calendar me-1"></i><?= date('d-m-Y', strtotime($row['tanggal_lahir'])); ?>
                        </span>
                    </td>
                    <td>
                        <span class="text-secondary"><i class="fa-solid fa-location-dot me-1 text-muted"></i><?= $row['alamat']; ?></span>
                    </td>
                    <td class="text-center">
                        <div class="action-group">
                            <button class="btn-action-edit" onclick='editPasien(<?= json_encode($row); ?>)' data-bs-toggle="modal" data-bs-target="#modalPasien" title="Edit">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                            <button class="btn-action-delete" onclick="konfirmasiHapus(<?= $row['id_pasien']; ?>, '<?= addslashes($row['nama_pasien']); ?>')" title="Hapus">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Form Pasien -->
<div class="modal fade" id="modalPasien" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <form action="pasien.php" method="POST">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold text-primary" id="modalTitle">Tambah Data Pasien</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <input type="hidden" name="id_pasien" id="id_pasien">
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">No. Rekam Medis (RM)</label>
                        <input type="text" name="no_rm" id="no_rm" class="form-control rounded-3" required placeholder="RM-202301">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Nama Pasien</label>
                        <input type="text" name="nama_pasien" id="nama_pasien" class="form-control rounded-3" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Jenis Kelamin</label>
                        <select name="jenis_kelamin" id="jenis_kelamin" class="form-select rounded-3" required>
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control rounded-3" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Alamat</label>
                        <textarea name="alamat" id="alamat" class="form-control rounded-3" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0 pe-4 pb-4">
                    <button type="button" class="btn btn-light rounded-3 px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" name="simpan_pasien" class="btn btn-primary rounded-3 px-4" style="background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%); border: none;">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function resetForm() {
    document.getElementById('modalTitle').innerText = 'Tambah Data Pasien';
    document.getElementById('id_pasien').value = '';
    document.getElementById('no_rm').value = '';
    document.getElementById('nama_pasien').value = '';
    document.getElementById('jenis_kelamin').value = 'L';
    document.getElementById('tanggal_lahir').value = '';
    document.getElementById('alamat').value = '';
}

function editPasien(data) {
    document.getElementById('modalTitle').innerText = 'Edit Data Pasien';
    document.getElementById('id_pasien').value = data.id_pasien;
    document.getElementById('no_rm').value = data.no_rm;
    document.getElementById('nama_pasien').value = data.nama_pasien;
    document.getElementById('jenis_kelamin').value = data.jenis_kelamin;
    document.getElementById('tanggal_lahir').value = data.tanggal_lahir;
    document.getElementById('alamat').value = data.alamat;
}

function konfirmasiHapus(id, nama) {
    Swal.fire({
        title: 'Hapus Data Pasien?',
        text: "Apakah Anda yakin ingin menghapus data pasien " + nama + "?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#e11d48',
        cancelButtonColor: '#94a3b8',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = 'pasien.php?hapus=' + id;
        }
    });
}
</script>

<?php include 'footer.php'; ?>