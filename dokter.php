<?php
include 'koneksi.php';

// Fitur Simpan & Update Dokter
if (isset($_POST['simpan_dokter'])) {
    $id_dokter = $_POST['id_dokter'];
    $nama_dokter = $_POST['nama_dokter'];
    $spesialisasi = $_POST['spesialisasi'];

    if ($id_dokter == "") {
        $query = "INSERT INTO dokter VALUES (NULL, '$nama_dokter', '$spesialisasi')";
    } else {
        $query = "UPDATE dokter SET nama_dokter='$nama_dokter', spesialisasi='$spesialisasi' WHERE id_dokter='$id_dokter'";
    }
    mysqli_query($koneksi, $query);
    header("Location: dokter.php");
}

// Fitur Hapus Dokter
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($koneksi, "DELETE FROM dokter WHERE id_dokter='$id'");
    header("Location: dokter.php");
}

include 'header.php';
?>

<div class="card-aesthetic p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1" style="color: #0284c7;">
                <i class="fa-solid fa-user-doctor me-2"></i>Data Dokter
            </h4>
            <p class="text-muted small mb-0">Kelola master data dokter dan spesialisasi medis.</p>
        </div>
        <button class="btn btn-primary rounded-pill px-4 py-2 fw-semibold shadow-sm" data-bs-toggle="modal" data-bs-target="#modalDokter" onclick="resetForm()" style="background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%); border: none;">
            <i class="fa-solid fa-plus me-2"></i>Tambah Dokter
        </button>
    </div>

    <div class="table-responsive">
        <table class="table-rs">
            <thead>
                <tr>
                    <th style="width: 50px;">NO</th>
                    <th>NAMA DOKTER</th>
                    <th>SPESIALISASI</th>
                    <th class="text-center text-nowrap" style="width: 120px;">AKSI</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                $data = mysqli_query($koneksi, "SELECT * FROM dokter ORDER BY id_dokter DESC");
                while ($row = mysqli_fetch_assoc($data)) {
                ?>
                <tr>
                    <td class="fw-bold text-muted text-center"><?= $no++; ?></td>
                    <td>
                        <strong class="text-dark"><?= $row['nama_dokter']; ?></strong>
                    </td>
                    <td>
                        <span class="badge bg-info bg-opacity-10 text-info px-3 py-2 rounded-pill fw-semibold">
                            <i class="fa-solid fa-stethoscope me-1"></i> <?= $row['spesialisasi']; ?>
                        </span>
                    </td>
                    <td class="text-center">
                        <div class="action-group">
                            <button class="btn-action-edit" onclick='editDokter(<?= json_encode($row); ?>)' data-bs-toggle="modal" data-bs-target="#modalDokter" title="Edit Data">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                            <button class="btn-action-delete" onclick="konfirmasiHapus(<?= $row['id_dokter']; ?>, '<?= addslashes($row['nama_dokter']); ?>')" title="Hapus Data">
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

<!-- Modal Form Dokter -->
<div class="modal fade" id="modalDokter" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <form action="dokter.php" method="POST">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold text-primary" id="modalTitle">Tambah Data Dokter</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <input type="hidden" name="id_dokter" id="id_dokter">
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Nama Dokter</label>
                        <input type="text" name="nama_dokter" id="nama_dokter" class="form-control rounded-3" required placeholder="Contoh: dr. Maya Sari, Sp.A">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Spesialisasi / Bidang</label>
                        <input type="text" name="spesialisasi" id="spesialisasi" class="form-control rounded-3" required placeholder="Contoh: Spesialis Anak">
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0 pe-4 pb-4">
                    <button type="button" class="btn btn-light rounded-3 px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" name="simpan_dokter" class="btn btn-primary rounded-3 px-4" style="background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%); border: none;">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function resetForm() {
    document.getElementById('modalTitle').innerText = 'Tambah Data Dokter';
    document.getElementById('id_dokter').value = '';
    document.getElementById('nama_dokter').value = '';
    document.getElementById('spesialisasi').value = '';
}

function editDokter(data) {
    document.getElementById('modalTitle').innerText = 'Edit Data Dokter';
    document.getElementById('id_dokter').value = data.id_dokter;
    document.getElementById('nama_dokter').value = data.nama_dokter;
    document.getElementById('spesialisasi').value = data.spesialisasi;
}

// Pop-up Hapus Modern (SweetAlert2)
function konfirmasiHapus(id, nama) {
    Swal.fire({
        title: 'Hapus Data Dokter?',
        text: "Apakah Anda yakin ingin menghapus data " + nama + "?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#e11d48',
        cancelButtonColor: '#94a3b8',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = 'dokter.php?hapus=' + id;
        }
    });
}
</script>

<?php include 'footer.php'; ?>