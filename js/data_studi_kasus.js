$(document).ready(function() {
  var table = $('#dataLatih').DataTable({
    "pageLength": 10,
    "columnDefs": [
      { "searchable": false, "orderable": false, "targets": 0 }
    ],
    "order": []
  });

  // Auto-numbering kolom No
  table.on('order.dt search.dt draw.dt', function () {
    table.column(0, {search:'applied', order:'applied'}).nodes().each(function (cell, i) {
      cell.innerHTML = i + 1;
    });
  }).draw();

  $("#btnTambahDataLatih").appendTo($('#dataLatih_filter'));

  $('#btnTambahDataLatih')
    .removeClass('btn-primary')
    .addClass('btn-info btn-xs shadow-sm')
    .css({
      'margin-top':'12px',
      'margin-bottom':'4px',
      'margin-left':'120px',
      'display':'block',
      'font-size':'0.70rem',
      'padding':'4px 16px',
      'border-radius':'16px',
      'font-weight':'600',
      'letter-spacing':'0.5px',
      'box-shadow':'0 2px 8px rgba(80,180,255,0.10)'
    })
    .html('<i class="fas fa-plus-circle mr-1"></i>Tambah Data Latih');

  $('#btnTambahDataLatih').on('click', function() {
    $('#modalTambahDataLatih').modal('show');
  });

  $('#formTambahDataLatih').on('submit', function(e) {
    e.preventDefault();
    var formData = $(this).serializeArray();
    var dataObj = {};
    formData.forEach(function(item) {
      dataObj[item.name] = item.value;
    });
    dataObj['keterangan'] = '-';

    // Tambahkan ke tabel DataTables (tanpa reload)
    table.row.add([
      "", // kolom No diisi otomatis
      dataObj['nama'],
      dataObj['pekerjaan'],
      dataObj['usia'],
      dataObj['status'],
      dataObj['penghasilan'],
      dataObj['kendaraan'],
      dataObj['kepemilikan'],
      dataObj['atap_bangunan'],
      '<span class="badge badge-secondary" style="padding:10px">-</span>',
      '<button class="btn btnPrintData btnDetailData" title="Detail" data-index="NEW">' +
      '<i class="fas fa-eye"></i> Detail</button>'
    ]).draw(false);

    // Simpan ke data.json via AJAX
    $.ajax({
      url: 'simpan_data_latih.php',
      method: 'POST',
      data: dataObj,
      success: function(res) {
        let hasil = res;
        if (typeof res === "string") hasil = JSON.parse(res);

        let badge = '-';
        if (hasil.keterangan === 'layak') {
          badge = "<span class='badge badge-success' style='padding:10px'>layak</span>";
        } else if (hasil.keterangan === 'tidak layak') {
          badge = "<span class='badge badge-danger' style='padding:10px'>tidak layak</span>";
        }

        // Update baris terakhir (data baru) dengan badge keterangan
        let rowIdx = table.rows().count() - 1;
        table.cell(rowIdx, 9).data(badge).draw(false);

        // Notifikasi sukses
        $('<div class="alert alert-success alert-dismissible fade show" role="alert" style="position:fixed;top:80px;right:30px;z-index:9999;min-width:220px;">' +
          '<i class="fas fa-check-circle mr-2"></i>Data berhasil ditambahkan!' +
          '<button type="button" class="close" data-dismiss="alert" aria-label="Close" style="outline:none;"><span aria-hidden="true">&times;</span></button>' +
          '</div>').appendTo('body');
        setTimeout(function() {
          $('.alert-success').alert('close');
        }, 2000);
      },
      error: function() {
        alert('Gagal menyimpan data ke file!');
      }
    });

    $('#modalTambahDataLatih').modal('hide');
    this.reset();
  });

  // Pie Chart Kelayakan (otomatis update)
  var ctx = document.getElementById('pieChartKelayakan').getContext('2d');
  var pieChart = new Chart(ctx, {
    type: 'pie',
    data: {
      labels: ['Layak', 'Tidak Layak'],
      datasets: [{
        data: [0, 0],
        backgroundColor: [
          'rgba(39, 174, 96, 0.8)',
          'rgba(231, 76, 60, 0.8)'
        ],
        borderColor: [
          'rgba(39, 174, 96, 1)',
          'rgba(231, 76, 60, 1)'
        ],
        borderWidth: 2
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: {
          display: true,
          position: 'bottom',
          labels: {
            font: { size: 15 }
          }
        },
        title: {
          display: true,
          text: 'Distribusi Data Kelayakan',
          font: { size: 18 }
        }
      }
    }
  });

  function updatePieChart() {
    $.getJSON('data.json', function(data) {
      var layak = 0, tidak = 0;
      data.forEach(function(row) {
        if (row.keterangan && row.keterangan.toLowerCase() === 'layak') layak++;
        else if (row.keterangan && row.keterangan.toLowerCase() === 'tidak layak') tidak++;
      });
      pieChart.data.datasets[0].data = [layak, tidak];
      pieChart.update();
    });
  }
  updatePieChart();
  setInterval(updatePieChart, 5000); // update tiap 5 detik

  // Event Detail Data
  $('#dataLatih tbody').on('click', '.btnDetailData', function() {
    var rowIdx = $(this).attr('data-index');
    if (rowIdx === 'NEW') {
      rowIdx = table.rows().count() - 1;
    }
    // Ambil data dari tabel
    var rowData = table.row(rowIdx).data();
    // Misal tanggal ada di kolom ke-10 (index 9)
    var tanggal = rowData[9]; // Pastikan index sesuai kolom tanggal
    if (tanggal && tanggal.length >= 10) {
      var tahun = tanggal.substr(0,4);
      var bulan = tanggal.substr(5,2);
      window.location.href = 'laporan_per_periode.php?bulan=' + bulan + '&tahun=' + tahun;
    } else {
      alert('Tanggal tidak ditemukan pada data ini!');
    }
  });

  $('#btnCetakPeriode').on('click', function() {
    var tahunSekarang = new Date().getFullYear();
    var tahunMulai = 2025;
    var $tahunSelect = $('#tahunCetak');
    $tahunSelect.empty();
    $tahunSelect.append('<option value="" disabled selected>Pilih Tahun</option>');
    for (var t = tahunMulai; t <= tahunSekarang; t++) {
      $tahunSelect.append('<option value="'+t+'">'+t+'</option>');
    }
    $('#modalCetakPeriode').modal('show');
  });

  // Validasi sebelum submit form pilih periode
  $('#formPilihPeriode').on('submit', function(e) {
    var bulan = $('#bulanCetak').val();
    var tahun = $('#tahunCetak').val();
    if (!bulan || !tahun) {
      alert('Silakan pilih bulan dan tahun terlebih dahulu!');
      e.preventDefault();
      return false;
    }
    // Jika valid, biarkan form submit secara default (GET)
  });
}); 