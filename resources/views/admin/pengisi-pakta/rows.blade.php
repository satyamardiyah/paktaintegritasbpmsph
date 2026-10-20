@forelse($paktas as $pakta)
  @php
    $initials = collect(explode(' ', $pakta->nama))->map(fn($w) => $w[0] ?? '')->take(2)->implode('');
  @endphp
  <tr>
    <td>
      <div class="name-cell">
        <div class="mini-avatar">{{ strtoupper($initials) }}</div>
        <div class="name-details">
          <div class="name-main">{{ $pakta->nama }}</div>
          <div class="name-sub">{{ $pakta->jabatan }}</div>
        </div>
      </div>
    </td>
    <td>
      <div class="addr-cell">
        <div class="addr-main">{{ $pakta->instansi }}</div>
        <div class="addr-sub">{{ $pakta->alamat }}</div>
      </div>
    </td>
    <td class="email-cell">{{ $pakta->email }}</td>
    <td><span class="badge" style="color:#0B4F9E; background:#EAF3FC">{{ $pakta->kepentingan }}</span></td>
    <td>{{ $pakta->created_at->translatedFormat('d M Y H:i') }}</td>
    <td class="mono">{{ $pakta->ref_number }}</td>
    <td><span class="badge done">✓ Terverifikasi</span></td>
    <td>
      @if($pakta->pdf_path)
        <div class="action-group">
          <a class="dl-link" href="{{ route('admin.pakta.view', $pakta->id) }}" target="_blank" rel="noopener">Lihat</a>
          <span class="sep">|</span>
          <a class="dl-link" href="{{ route('admin.pakta.download', $pakta->id) }}">Unduh</a>
        </div>
      @else
        —
      @endif
    </td>
    <td>
      <div class="action-group">
        @if($pakta->penilaian)
          <a class="btn-edit" href="{{ route('admin.pakta.penilaian', $pakta->id) }}" title="Edit Penilaian">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
          </a>
          <a class="dl-link" href="{{ route('admin.penilaian.view', $pakta->penilaian->id) }}" target="_blank" rel="noopener">Lihat</a>
          <span class="sep">|</span>
          <a class="dl-link" href="{{ route('admin.penilaian.download', $pakta->penilaian->id) }}">Unduh</a>
        @else
          <a class="btn-add" href="{{ route('admin.pakta.penilaian', $pakta->id) }}" title="Tambah Penilaian">+</a>
        @endif
      </div>
    </td>
  </tr>
@empty
  <tr><td colspan="9" style="text-align:center; color:var(--muted); padding:30px;">Belum ada data.</td></tr>
@endforelse
