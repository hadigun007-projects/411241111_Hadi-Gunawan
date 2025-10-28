<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Laporan Pelanggan & Transaksi</title>
  <style>
    :root { --primary:#1f6feb; --border:#e5e7eb; --muted:#6b7280; }
    * { box-sizing: border-box; }
    body { font-family: ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial, "Apple Color Emoji", "Segoe UI Emoji"; margin: 0; background: #fff; color:#111827; }
    .container { max-width: 1100px; margin: 32px auto; padding: 0 16px; }
    .tabs { display: flex; gap: 8px; border-bottom: 1px solid var(--border); }
    .tab-btn {
      appearance: none; background: #f3f4f6; color:#111827; border:1px solid var(--border);
      padding: 10px 14px; border-top-left-radius: 10px; border-top-right-radius: 10px;
      cursor: pointer; font-weight: 600;
    }
    .tab-btn[aria-selected="true"] {
      background:#fff; border-bottom-color:#fff; color: var(--primary);
    }
    .tab-panel { display: none; padding: 16px 0; }
    .tab-panel[aria-hidden="false"] { display: block; }

    .card { border:1px solid var(--border); border-radius: 12px; padding: 16px; background:#fff; }
    .table-wrap { overflow-x: auto; }
    table { width: 100%; border-collapse: collapse; }
    thead th {
      text-align: left; font-size: 14px; color: var(--muted); font-weight: 600; border-bottom:1px solid var(--border); padding: 10px 8px;
      white-space: nowrap;
    }
    tbody td { border-bottom:1px solid var(--border); padding: 12px 8px; vertical-align: top; }
    .empty { color: var(--muted); font-style: italic; padding: 12px 0; }
    .badge { display:inline-block; padding:2px 8px; border-radius:999px; border:1px solid var(--border); font-size:12px; color:#374151; background:#f9fafb; }
    .right { text-align:right; white-space: nowrap; }
    .muted { color: var(--muted); font-size: 12px; }
  </style>
</head>
<body>
  <div class="container">
    <h1 style="margin: 2rem 0;">Laporan Data</h1>

    <div class="tabs" role="tablist" aria-label="Laporan Tabs">
      <button class="tab-btn" role="tab" id="tab-pelanggan" aria-controls="panel-pelanggan" aria-selected="true">Pelanggan {{count($pelanggan)}}</button>
      <button class="tab-btn" role="tab" id="tab-transaksi" aria-controls="panel-transaksi" aria-selected="false">Transaksi {{count($transaksi)}}</button>
      <button class="tab-btn" role="tab" id="tab-join" aria-controls="panel-join" aria-selected="false">Hasil Join</button>
    </div>

    {{-- Panel Pelanggan --}}
    <section class="tab-panel" id="panel-pelanggan" role="tabpanel" aria-labelledby="tab-pelanggan" aria-hidden="false">
      <div class="card">
        <div class="table-wrap">
          @if(($pelanggan ?? collect())->count() === 0)
            <div class="empty">Belum ada data pelanggan.</div>
          @else
            <table>
              <thead>
              <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Email</th>
                <th>No HP</th>
                <th>Dibuat</th>
                <th>Diupdate</th>
              </tr>
              </thead>
              <tbody>
              @foreach($pelanggan as $p)
                <tr>
                  <td>{{ $p->id_pelanggan }}</td>
                  <td>{{ $p->nama_pelanggan }}</td>
                  <td>{{ $p->email }}</td>
                  <td><span class="badge">{{ $p->no_hp }}</span></td>
                  <td>{{ \Illuminate\Support\Carbon::parse($p->created_at)->format('Y-m-d H:i') }}</td>
                  <td>{{ \Illuminate\Support\Carbon::parse($p->updated_at)->format('Y-m-d H:i') }}</td>
                </tr>
              @endforeach
              </tbody>
            </table>
          @endif
        </div>
        @if(method_exists(($pelanggan ?? null), 'links'))
          <div style="margin-top:12px;">{{ $pelanggan->links() }}</div>
        @endif
      </div>
    </section>

    {{-- Panel Transaksi --}}
    <section class="tab-panel" id="panel-transaksi" role="tabpanel" aria-labelledby="tab-transaksi" aria-hidden="true">
      <div class="card">
        <div class="table-wrap">
          @if(($transaksi ?? collect())->count() === 0)
            <div class="empty">Belum ada data transaksi.</div>
          @else
            <table>
              <thead>
              <tr>
                <th>ID</th>
                <th>ID Pelanggan</th>
                <th>Tanggal Transaksi</th>
                <th class="right">Total Transaksi</th>
                <th>Dibuat</th>
                <th>Diupdate</th>
              </tr>
              </thead>
              <tbody>
              @foreach($transaksi as $t)
                <tr>
                  <td>{{ $t->id_transaksi }}</td>
                  <td>{{ $t->id_pelanggan }}</td>
                  <td>{{ \Illuminate\Support\Carbon::parse($t->tanggal_transaksi)->format('Y-m-d H:i') }}</td>
                  <td class="right">Rp {{ number_format($t->total_transaksi, 0, ',', '.') }}</td>
                  <td>{{ \Illuminate\Support\Carbon::parse($t->created_at)->format('Y-m-d H:i') }}</td>
                  <td>{{ \Illuminate\Support\Carbon::parse($t->updated_at)->format('Y-m-d H:i') }}</td>
                </tr>
              @endforeach
              </tbody>
            </table>
          @endif
        </div>
        @if(method_exists(($transaksi ?? null), 'links'))
          <div style="margin-top:12px;">{{ $transaksi->links() }}</div>
        @endif
      </div>
    </section>

    {{-- Panel Hasil Join --}}
    <section class="tab-panel" id="panel-join" role="tabpanel" aria-labelledby="tab-join" aria-hidden="true">
      <div class="card">
        {{-- Button Tambah Transaksi --}}
    <div style="margin-bottom: 12px; display:flex; justify-content:flex-end;">
      <button id="btnOpenModal" style="padding:8px 14px; border:none; background:#1f6feb; color:white; border-radius:6px; cursor:pointer;">
        + Tambah Transaksi
      </button>
    </div>
        <div class="table-wrap">
          @if(($joined ?? collect())->count() === 0)
            <div class="empty">Belum ada data hasil join.</div>
          @else
            <table>
              <thead>
                <th>ID Pelanggan</th>
                <th>Nama</th>
                <th>Email</th>
                <th>No HP</th>
                <th>Tanggal Transaksi</th>
                <th class="right">Total Transaksi</th>
                <th>Aksi</th>
              </tr>
              </thead>
              <tbody>
                @foreach($joined as $row)
                <tr>
                  <td>{{ $row->id_pelanggan ?? $row->pelanggan_id ?? $row->id }}</td>
                  <td>{{ $row->nama_pelanggan }}</td>
                  <td>{{ $row->email }}</td>
                  <td><span class="badge">{{ $row->no_hp }}</span></td>
                  <td>{{ \Illuminate\Support\Carbon::parse($row->tanggal_transaksi)->format('Y-m-d H:i') }}</td>
                  <td class="right">Rp {{ number_format($row->total_transaksi, 0, ',', '.') }}</td>
                  <td style="display:flex; justify-content:flex-end;gap: 10px;">
                    <button style="cursor:pointer;" onclick="editTransaksi({{$row->id_transaksi}}, {{$row->id_pelanggan}}, '{{$row->tanggal_transaksi}}', {{$row->total_transaksi}})" type="button">Edit</button>
                    <button style="cursor:pointer;" onclick="deleteTransaksi({{$row->id_transaksi}})" type="button">Hapus</button>
                  </td>
                </tr>
              @endforeach
              </tbody>
            </table>
          @endif
        </div>
        @if(method_exists(($joined ?? null), 'links'))
          <div style="margin-top:12px;">{{ $joined->links() }}</div>
        @endif
      </div>
    </section>
    <div id="modalTransaksi" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); justify-content:center; align-items:center;">
  <div style="background:white; width:400px; border-radius:10px; padding:20px; position:relative;">

    {{-- Tombol close --}}
    <button id="btnCloseModal"
      style="position:absolute; top:10px; right:10px; border:none; background:transparent; font-size:18px; cursor:pointer;">
      ✖
    </button>

      <h3 id="modalTitle" style="margin:0 0 16px 0;">Tambah/Edit Transaksi Baru</h3>

      <div style="margin-bottom:12px;">
        <label for="id_pelanggan">Pelanggan</label><br>
        <select name="id_pelanggan" id="id_pelanggan" style="width:100%; padding:8px;">
          @foreach($pelanggan as $p)
            <option value="{{ $p->id_pelanggan }}">{{ $p->nama_pelanggan }}</option>
          @endforeach
        </select>
      </div>

      <div style="margin-bottom:12px;">
        <label for="tanggal_transaksi">Tanggal Transaksi</label><br>
        <input type="datetime-local" name="tanggal_transaksi" id="tanggal_transaksi" style="width:100%; padding:8px;" required>
      </div>

      <div style="margin-bottom:12px;">
        <label for="total_transaksi">Total Transaksi</label><br>
        <input type="number" name="total_transaksi" id="total_transaksi" style="width:100%; padding:8px;" required>
      </div>

      <button type="submit" onclick="createTransaksi()" style="padding:10px 14px; background:#1f6feb; color:white; border:none; border-radius:6px; cursor:pointer;">
        Simpan
      </button>

  </div>
</div>
  </div>

  <script>

    let mode;
    let editedId;
    
    // Tab logic (vanilla JS, accessible-ish)
    (function () {
      const tabs = document.querySelectorAll('[role="tab"]');
      const panels = document.querySelectorAll('[role="tabpanel"]');

      function activateTab(tab) {
        tabs.forEach(t => t.setAttribute('aria-selected', 'false'));
        panels.forEach(p => p.setAttribute('aria-hidden', 'true'));

        tab.setAttribute('aria-selected', 'true');
        const panel = document.getElementById(tab.getAttribute('aria-controls'));
        if (panel) panel.setAttribute('aria-hidden', 'false');
      }

      tabs.forEach(tab => {
        tab.addEventListener('click', () => activateTab(tab));
        tab.addEventListener('keydown', (e) => {
          const idx = Array.from(tabs).indexOf(document.querySelector('[aria-selected="true"]'));
          if (e.key === 'ArrowRight') {
            e.preventDefault();
            const next = tabs[(idx + 1) % tabs.length];
            next.focus(); activateTab(next);
          } else if (e.key === 'ArrowLeft') {
            e.preventDefault();
            const prev = tabs[(idx - 1 + tabs.length) % tabs.length];
            prev.focus(); activateTab(prev);
          }
        });
      });
    })();

    const modal = document.getElementById('modalTransaksi');
    const btnOpen = document.getElementById('btnOpenModal');
    const btnClose = document.getElementById('btnCloseModal');

    btnOpen.addEventListener('click', () => {
      modal.style.display = 'flex';
    });

    btnClose.addEventListener('click', () => {
      modal.style.display = 'none';
    });

    modal.addEventListener('click', (e) => {
      if (e.target === modal) {
        modal.style.display = 'none';
      }
    });

     async function createTransaksi() {
      const id_pelanggan = document.getElementById('id_pelanggan').value
      const tanggal_transaksi = document.getElementById('tanggal_transaksi').value
      const total_transaksi = document.getElementById('total_transaksi').value

      if(id_pelanggan === '' || tanggal_transaksi === '' || total_transaksi === ''){
        alert('Semua field harus diisi')
        return
      }

      if(mode == 'edit'){
        const res = await fetch('/edit/'+editedId, {
        method: 'PATCH',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
          id_pelanggan,
          tanggal_transaksi,
          total_transaksi
        })
      })

      const data = await res.json()

      if(data.success){
        alert(data.message)
        modal.style.display = 'none';
        location.reload()
      }else{
        alert(data.message)
      }
        return;
      }

      const res = await fetch('/create', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
          id_pelanggan,
          tanggal_transaksi,
          total_transaksi
        })
      })

      const data = await res.json()

      if(data.success){
        alert(data.message)
        modal.style.display = 'none';
        location.reload()
      }else{
        alert(data.message)
      }
    }
     
    
    async function deleteTransaksi(id) {
      if(!confirm("Yakin mau hapus data?: " + id)){
        alert('Hapus data dibatalkan.')
        return;
      }

      const res = await fetch('/destroy/'+id, {
        method: 'DELETE',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
      })

     let data
      try {
        data = await res.json()
      } catch (e) {
        alert('Gagal menghapus: respon tidak valid.')
        return
      }

      if(data.success){
        alert(data.message)
        modal.style.display = 'none';
        location.reload()
      }else{
        alert(data.message)
      }
    }

    function toDatetimeLocal(value) {
      // value: 'YYYY-MM-DD HH:MM:SS' → 'YYYY-MM-DDTHH:MM'
      return value.replace(' ', 'T').slice(0, 16)
    }
    
    
    async function editTransaksi(id, id_pelanggan, tanggal_transaksi, total_transaksi) {

      if (tanggal_transaksi.length === 10) {
        tanggal_transaksi = `${tanggal_transaksi}T00:00`;
      }

      mode = 'edit';
      editedId = id;

      document.getElementById('id_pelanggan').value = id_pelanggan
      document.getElementById('tanggal_transaksi').value = tanggal_transaksi
      document.getElementById('total_transaksi').value = total_transaksi

      modal.style.display = 'flex';


      // if(id_pelanggan === '' || tanggal_transaksi === '' || total_transaksi === ''){
      //   alert('Semua field harus diisi')
      //   return
      // }

    //   const res = await fetch('/destroy/'+id, {
    //     method: 'DELETE',
    //     headers: {
    //       'Content-Type': 'application/json',
    //       'Accept': 'application/json',
    //       'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    //     },
    //   })

    //  let data
    //   try {
    //     data = await res.json()
    //   } catch (e) {
    //     alert('Gagal menghapus: respon tidak valid.')
    //     return
    //   }

    //   if(data.success){
    //     alert(data.message)
    //     modal.style.display = 'none';
    //     location.reload()
    //   }else{
    //     alert(data.message)
    //   }
    }

  </script>
</body>
</html>
