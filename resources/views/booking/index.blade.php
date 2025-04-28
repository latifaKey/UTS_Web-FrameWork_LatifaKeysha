@extends('layouts.app')

@section('content')
<div class="card animate__animated animate__fadeIn">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="fas fa-list me-2"></i>Daftar Booking</h5>
        <div class="d-flex">
            <form action="{{ route('booking.index') }}" method="GET" class="form-inline me-2">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Cari booking..." value="{{ request('search') }}">
                    <button class="btn btn-outline-primary" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>
            @if(Auth::user()->role !== 'admin')
            <a href="{{ route('booking.create') }}" class="btn btn-primary">
                <i class="fas fa-plus-circle me-1"></i>Tambah
            </a>
            @endif
        </div>
    </div>
    <div class="card-body">
        @if($bookings->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Pemesan</th>
                            @if(Auth::user()->role === 'admin')
                            <th>Dibuat Oleh</th>
                            @endif
                            <th>Jenis Lapangan</th>
                            <th>Tanggal</th>
                            <th>Waktu</th>
                            <th>Kontak</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bookings as $index => $booking)
                            <tr class="align-middle">
                                <td>{{ $bookings->firstItem() + $index }}</td>
                                <td><strong>{{ $booking->nama_pemesan }}</strong></td>
                                @if(Auth::user()->role === 'admin')
                                <td>
                                    @if($booking->user)
                                        <span class="badge bg-secondary">{{ $booking->user->name }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                @endif
                                <td>
                                    @if($booking->jenis_lapangan == 'futsal')
                                        <span class="badge" style="background-color: #4e73df;">
                                            <i class="fas fa-futbol me-1"></i>Futsal
                                        </span>
                                    @elseif($booking->jenis_lapangan == 'badminton')
                                        <span class="badge" style="background-color: #1cc88a;">
                                            <i class="fas fa-table-tennis-paddle-ball me-1"></i>Badminton
                                        </span>
                                    @else
                                        <span class="badge" style="background-color: #f6c23e;">
                                            <i class="fas fa-baseball me-1"></i>Tenis
                                        </span>
                                    @endif
                                </td>
                                <td>{{ \Carbon\Carbon::parse($booking->tanggal_booking)->format('d M Y') }}</td>
                                <td>
                                    <i class="far fa-clock me-1"></i>
                                    {{ substr($booking->jam_mulai, 0, 5) }} - {{ substr($booking->jam_selesai, 0, 5) }}
                                </td>
                                <td>
                                    <i class="fas fa-phone me-1"></i>{{ $booking->kontak }}
                                </td>
                                <td>
                                    @if($booking->status == 'terkonfirmasi')
                                        <span class="badge badge-confirmed">
                                            <i class="fas fa-check-circle me-1"></i>Terkonfirmasi
                                        </span>
                                    @else
                                        <span class="badge badge-pending">
                                            <i class="fas fa-clock me-1"></i>Menunggu
                                        </span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-1">
                                        <a href="{{ route('booking.show', $booking->id) }}" class="btn btn-sm btn-info text-white" data-bs-toggle="tooltip" title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        @if(Auth::user()->role === 'admin')
                                            @if($booking->status == 'pending')
                                            <form action="{{ route('booking.approve', $booking->id) }}" method="POST" class="d-inline approve-form m-0">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success" data-bs-toggle="tooltip" title="Setujui">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>
                                            @endif

                                            <a href="{{ route('booking.edit', $booking->id) }}" class="btn btn-sm btn-warning text-white" data-bs-toggle="tooltip" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <form action="{{ route('booking.destroy', $booking->id) }}" method="POST" class="d-inline delete-form m-0">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" data-bs-toggle="tooltip" title="Hapus">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        @elseif($booking->user_id == Auth::id() && $booking->status == 'pending')
                                            <a href="{{ route('booking.edit', $booking->id) }}" class="btn btn-sm btn-warning text-white" data-bs-toggle="tooltip" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-end mt-3">
                {{ $bookings->links() }}
            </div>
        @else
            <div class="alert alert-info d-flex align-items-center animate__animated animate__fadeIn">
                <i class="fas fa-info-circle me-3 fs-4"></i>
                <div>
                    Belum ada data booking. <a href="{{ route('booking.create') }}" class="alert-link">Buat booking baru</a> sekarang!
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Simpler delete confirmation
    const deleteForms = document.querySelectorAll('.delete-form');

    deleteForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            if (confirm('Apakah Anda yakin ingin menghapus booking ini?')) {
                this.submit();
            }
        });
    });

    // Simpler approve confirmation
    const approveForms = document.querySelectorAll('.approve-form');

    approveForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            if (confirm('Apakah Anda yakin ingin menyetujui booking ini?')) {
                this.submit();
            }
        });
    });
});
</script>
@endpush
