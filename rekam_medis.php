<?php
include 'koneksi.php';

// Fitur Simpan & Update Rekam Medis
if (isset($_POST['simpan_rekam'])) {
    $id_rekam        = $_POST['id_rekam'];
    $id_pasien       = $_POST['id_pasien'];
    $id_dokter       = $_POST['id_dokter'];
    $id_obat         = $_POST['id_obat'];
    $tanggal_periksa = $_POST['tanggal_periksa'];
    $keluhan         = $_POST['keluhan'];
    $diagnosa        = $_POST['diagnosa'];
    $tindakan        = $_POST['tindakan'];
    $resep           = $_POST['resep'];

    if ($id_rekam == "") {
        $query = "INSERT INTO rekam_medis VALUES (NULL, '$id_pasien', '$id_dokter', '$id_obat', '$tanggal_periksa', '$keluhan', '$diagnosa', '$tindakan', '$resep')";
    } else {
        $query = "UPDATE rekam_medis SET id_pasien='$id_pasien', id_dokter='$id_dokter', id_obat='$id_obat', tanggal_periksa='$tanggal_periksa', keluhan='$keluhan', diagnosa='$diagnosa', tindakan='$tindakan', resep='$resep' WHERE id_rekam='$id_rekam'";
    }
    mysqli_query($koneksi, $query);
    header("Location: rekam_medis.php");
}

// Fitur Hapus Rekam Medis
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($koneksi, "DELETE FROM rekam_medis WHERE id_rekam='$id'");
    header("Location: rekam_medis.php");
}

include 'header.php';
?>

<div class="card-aesthetic p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1" style="color: #0284c7;">
                <i class="fa-solid fa-notes-medical me-2"></i>Riwayat Pemeriksaan
            </h4>
            <p class="text-muted small mb-0">Daftar rekam medis pasien terintegrasi (SQL JOIN).</p>
        </div>
        <button class="btn btn-primary rounded-pill px-4 py-2 fw-semibold shadow-sm" data-bs-toggle="modal" data-bs-target="#modalRekam" onclick="resetForm()" style="background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%); border: none;">
            <i class="fa-solid fa-plus me-2"></i>Tambah Rekam Medis
        </button>
    </div>

    <div class="table-responsive">
        <table class="table-rs">
            <thead>
                <tr>
                    <th style="width: 50px;">NO</th>
                    <th class="text-nowrap">TGL PERIKSA</th>
                    <th class="text-nowrap">PASIEN</th>
                    <th class="text-nowrap">DOKTER</th>
                    <th>DIAGNOSA & KELUHAN</th>
                    <th>RESEP & TINDAKAN</th>
                    <th class="text-nowrap">OBAT</th>
                    <th class="text-center text-nowrap" style="width: 100px;">AKSI</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                $query_join = "SELECT rm.*, 
                                      p.nama_pasien, p.no_rm, 
                                      d.nama_dokter, 
                                      o.nama_obat 
                               FROM rekam_medis rm
                               LEFT JOIN pasien p ON rm.id_pasien = p.id_pasien
                               LEFT JOIN dokter d ON rm.id_dokter = d.id_dokter
                               LEFT JOIN obat o ON rm.id_obat = o.id_obat
                               ORDER BY rm.id_rekam DESC";
                $data = mysqli_query($koneksi, $query_join);
                while ($row = mysqli_fetch_assoc($data)) {
                ?>
                <tr>
                    <td class="fw-bold text-muted text-center"><?= $no++; ?></td>
                    <td class="text-nowrap">
                        <span class="badge bg-secondary bg-opacity-10 text-secondary px-3 py-2 rounded-pill fw-semibold">
                            <i class="fa-regular fa-calendar me-1"></i><?= date('d-m-Y', strtotime($row['tanggal_periksa'])); ?>
                        </span>
                    </td>
                    <td class="text-nowrap">
                        <strong class="text-dark d-block"><?= $row['nama_pasien'] ? $row['nama_pasien'] : '-'; ?></strong>
                        <span class="badge bg-primary bg-opacity-10 text-primary px-2 py-1 rounded-pill font-monospace" style="font-size: 0.75rem;">
                            <?= $row['no_rm'] ? $row['no_rm'] : '-'; ?>
                        </span>
                    </td>
                    <td class="text-nowrap">
                        <span class="fw-semibold text-dark"><i class="fa-solid fa-user-md me-1 text-muted"></i><?= $row['nama_dokter'] ? $row['nama_dokter'] : '-'; ?></span>
                    </td>
                    <td>
                        <span class="badge bg-warning bg-opacity-10 text-dark mb-1 fw-bold px-2 py-1 rounded-3">
                            <?= $row['diagnosa']; ?>
                        </span>
                        <div class="small text-secondary"><?= $row['keluhan']; ?></div>
                    </td>
                    <td>
                        <div class="small fw-semibold text-dark"><i class="fa-solid fa-user-gear me-1 text-muted"></i><?= $row['tindakan']; ?></div>
                        <div class="small text-muted"><em>Resep: <?= $row['resep']; ?></em></div>
                    </td>
                    <td class="text-nowrap">
                        <?php if(!empty($row['nama_obat'])) { ?>
                            <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill fw-bold">
                                <i class="fa-solid fa-pills me-1"></i> <?= $row['nama_obat']; ?>
                            </span>
                        <?php } else { ?>
                            <span class="badge bg-danger bg-opacity-10 text-danger px-3 py-2 rounded-pill fw-semibold">
                                Tidak ada obat
                            </span>
                        <?php } ?>
                    </td>
                    <td class="text-center">
                        <div class="action-group">
                            <button class="btn-action-edit" onclick='editRekam(<?= json_encode($row); ?>)' data-bs-toggle="modal" data-bs-target="#modalRekam" title="Edit Data">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                            <button class="btn-action-delete" onclick="konfirmasiHapus(<?= $row['id_rekam']; ?>)" title="Hapus Data">
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

<!-- Modal Form Rekam Medis -->
<div class="modal fade" id="modalRekam" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <form action="rekam_medis.php" method="POST">
                <div class="modal-header border-0 pb-0 pe-4 pt-4 ps-4">
                    <h5 class="modal-title fw-bold text-primary" id="modalTitle">
                        <i class="fa-solid fa-file-medical me-2"></i>Tambah Rekam Medis
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <input type="hidden" name="id_rekam" id="id_rekam">
                    
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Pilih Pasien</label>
                            <select name="id_pasien" id="id_pasien" class="form-select rounded-3" required>
                                <option value="">-- Pilih Pasien --</option>
                                <?php
                                $pasien = mysqli_query($koneksi, "SELECT * FROM pasien ORDER BY nama_pasien ASC");
                                while ($p = mysqli_fetch_assoc($pasien)) {
                                    echo "<option value='".$p['id_pasien']."'>".$p['no_rm']." - ".$p['nama_pasien']."</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Pilih Dokter Pemeriksa</label>
                            <select name="id_dokter" id="id_dokter" class="form-select rounded-3" required>
                                <option value="">-- Pilih Dokter --</option>
                                <?php
                                $dokter = mysqli_query($koneksi, "SELECT * FROM dokter ORDER BY nama_dokter ASC");
                                while ($d = mysqli_fetch_assoc($dokter)) {
                                    echo "<option value='".$d['id_dokter']."'>".$d['nama_dokter']." (".$d['spesialisasi'].")</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Pilih Obat</label>
                            <select name="id_obat" id="id_obat" class="form-select rounded-3" required>
                                <option value="">-- Pilih Obat --</option>
                                <?php
                                $obat = mysqli_query($koneksi, "SELECT * FROM obat ORDER BY nama_obat ASC");
                                while ($o = mysqli_fetch_assoc($obat)) {
                                    echo "<option value='".$o['id_obat']."'>".$o['nama_obat']." (Stok: ".$o['stok'].")</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Tanggal Periksa</label>
                            <input type="date" name="tanggal_periksa" id="tanggal_periksa" class="form-control rounded-3" required value="<?= date('Y-m-d'); ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Keluhan Pasien</label>
                            <textarea name="keluhan" id="keluhan" class="form-control rounded-3" rows="2" placeholder="Gejala/keluhan pasien..." required></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Hasil Diagnosa</label>
                            <textarea name="diagnosa" id="diagnosa" class="form-control rounded-3" rows="2" placeholder="Hasil analisa medis..." required></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Tindakan</label>
                            <textarea name="tindakan" id="tindakan" class="form-control rounded-3" rows="2" placeholder="Tindakan medis yang diberikan..." required></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Resep / Dosis Pakai</label>
                            <input type="text" name="resep" id="resep" class="form-control rounded-3" placeholder="Contoh: 3x1 tablet sehari" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0 pe-4 pb-4">
                    <button type="button" class="btn btn-light rounded-3 px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" name="simpan_rekam" class="btn btn-primary rounded-3 px-4" style="background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%); border: none;">Simpan Rekam Medis</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function resetForm() {
    document.getElementById('modalTitle').innerHTML = '<i class="fa-solid fa-file-medical me-2"></i>Tambah Rekam Medis';
    document.getElementById('id_rekam').value = '';
    document.getElementById('id_pasien').value = '';
    document.getElementById('id_dokter').value = '';
    document.getElementById('id_obat').value = '';
    document.getElementById('tanggal_periksa').value = '<?= date('Y-m-d'); ?>';
    document.getElementById('keluhan').value = '';
    document.getElementById('diagnosa').value = '';
    document.getElementById('tindakan').value = '';
    document.getElementById('resep').value = '';
}

function editRekam(data) {
    document.getElementById('modalTitle').innerHTML = '<i class="fa-solid fa-pen-to-square me-2"></i>Edit Rekam Medis';
    document.getElementById('id_rekam').value = data.id_rekam;
    document.getElementById('id_pasien').value = data.id_pasien;
    document.getElementById('id_dokter').value = data.id_dokter;
    document.getElementById('id_obat').value = data.id_obat;
    document.getElementById('tanggal_periksa').value = data.tanggal_periksa;
    document.getElementById('keluhan').value = data.keluhan;
    document.getElementById('diagnosa').value = data.diagnosa;
    document.getElementById('tindakan').value = data.tindakan;
    document.getElementById('resep').value = data.resep;
}

function konfirmasiHapus(id) {
    Swal.fire({
        title: 'Hapus Rekam Medis?',
        text: "Apakah Anda yakin ingin menghapus catatan rekam medis ini?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#e11d48',
        cancelButtonColor: '#94a3b8',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = 'rekam_medis.php?hapus=' + id;
        }
    });
}
</script>

<?php include 'footer.php'; ?>