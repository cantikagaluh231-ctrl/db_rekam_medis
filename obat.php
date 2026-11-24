<?php
include 'koneksi.php';

// Fitur Simpan & Update Obat
if (isset($_POST['simpan_obat'])) {
    $id_obat = $_POST['id_obat'];
    $nama_obat = $_POST['nama_obat'];
    $satuan = $_POST['satuan'];
    $stok = $_POST['stok'];

    if ($id_obat == "") {
        $query = "INSERT INTO obat VALUES (NULL, '$nama_obat', '$satuan', '$stok')";
    } else {
        $query = "UPDATE obat SET nama_obat='$nama_obat', satuan='$satuan', stok='$stok' WHERE id_obat='$id_obat'";
    }
    mysqli_query($koneksi, $query);
    header("Location: obat.php");
}

// Fitur Hapus Obat
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($koneksi, "DELETE FROM obat WHERE id_obat='$id'");
    header("Location: obat.php");
}

include 'header.php';
?>

<div class="card-aesthetic p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1" style="color: #0284c7;">
                <i class="fa-solid fa-pills me-2"></i>Data Obat
            </h4>
            <p class="text-muted small mb-0">Kelola master inventaris dan persediaan obat Rumah Sakit.</p>
        </div>
        <button class="btn btn-primary rounded-pill px-4 py-2 fw-semibold shadow-sm" data-bs-toggle="modal" data-bs-target="#modalObat" onclick="resetForm()" style="background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%); border: none;">
            <i class="fa-solid fa-plus me-2"></i>Tambah Obat
        </button>
    </div>

    <div class="table-responsive">
        <table class="table-rs">
            <thead>
                <tr>
                    <th style="width: 50px;">NO</th>
                    <th>NAMA OBAT</th>
                    <th>SATUAN</th>
                    <th>STOK</th>
                    <th class="text-center text-nowrap" style="width: 120px;">AKSI</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                $data = mysqli_query($koneksi, "SELECT * FROM obat ORDER BY id_obat DESC");
                while ($row = mysqli_fetch_assoc($data)) {
                ?>
                <tr>
                    <td class="fw-bold text-muted text-center"><?= $no++; ?></td>
                    <td>
                        <strong class="text-dark"><?= $row['nama_obat']; ?></strong>
                    </td>
                    <td>
                        <span class="badge bg-secondary bg-opacity-10 text-secondary px-3 py-2 rounded-pill fw-semibold">
                            <i class="fa-solid fa-box me-1"></i> <?= $row['satuan']; ?>
                        </span>
                    </td>
                    <td>
                        <span class="badge bg-warning bg-opacity-10 text-warning px-3 py-2 rounded-pill fw-bold font-monospace">
                            <?= $row['stok']; ?> Item
                        </span>
                    </td>
                    <td class="text-center">
                        <div class="action-group">
                            <button class="btn-action-edit" onclick='editObat(<?= json_encode($row); ?>)' data-bs-toggle="modal" data-bs-target="#modalObat" title="Edit Data">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                            <button class="btn-action-delete" onclick="konfirmasiHapus(<?= $row['id_obat']; ?>, '<?= addslashes($row['nama_obat']); ?>')" title="Hapus Data">
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

<!-- Modal Form Obat -->
<div class="modal fade" id="modalObat" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <form action="obat.php" method="POST">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold text-primary" id="modalTitle">Tambah Data Obat</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <input type="hidden" name="id_obat" id="id_obat">
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Nama Obat</label>
                        <input type="text" name="nama_obat" id="nama_obat" class="form-control rounded-3" required placeholder="Contoh: Paracetamol 500mg">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Satuan</label>
                        <input type="text" name="satuan" id="satuan" class="form-control rounded-3" required placeholder="Contoh: Tablet / Kapsul / Botol">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Stok</label>
                        <input type="number" name="stok" id="stok" class="form-control rounded-3" required placeholder="Jumlah stok">
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0 pe-4 pb-4">
                    <button type="button" class="btn btn-light rounded-3 px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" name="simpan_obat" class="btn btn-primary rounded-3 px-4" style="background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%); border: none;">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function resetForm() {
    document.getElementById('modalTitle').innerText = 'Tambah Data Obat';
    document.getElementById('id_obat').value = '';
    document.getElementById('nama_obat').value = '';
    document.getElementById('satuan').value = '';
    document.getElementById('stok').value = '';
}

function editObat(data) {
    document.getElementById('modalTitle').innerText = 'Edit Data Obat';
    document.getElementById('id_obat').value = data.id_obat;
    document.getElementById('nama_obat').value = data.nama_obat;
    document.getElementById('satuan').value = data.satuan;
    document.getElementById('stok').value = data.stok;
}

// Pop-up Hapus Modern (SweetAlert2)
function konfirmasiHapus(id, nama) {
    Swal.fire({
        title: 'Hapus Data Obat?',
        text: "Apakah Anda yakin ingin menghapus data obat " + nama + "?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#e11d48',
        cancelButtonColor: '#94a3b8',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = 'obat.php?hapus=' + id;
        }
    });
}
</script>

<?php include 'footer.php'; ?>