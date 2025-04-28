@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0"><i class="fas fa-trash me-2"></i>Riwayat Booking Dihapus</h5>
    </div>
    <div class="card-body">
        @if($deletedBookings->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Nama Pemesan</th>
                            <th>Jenis Lapangan</th>
                            <th>Tanggal</th>
                            <th>Waktu</th>
                            <th>Kontak</th>
                            <th>Status</th>
                            <th>Dihapus Pada</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($deletedBookings as $index => $booking)
                            <tr>
                                <td>{{ $deletedBookings->firstItem() + $index }}</td>
                                <td>{{ $booking->nama_pemesan }}</td>
                                <td>
                                    <span class="badge {{ $booking->jenis_lapangan == 'futsal' ? 'bg-primary' : ($booking->jenis_lapangan == 'badminton' ? 'bg-success' : 'bg-warning') }}">
                                        {{ ucfirst($booking->jenis_lapangan) }}
                                    </span>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($booking->tanggal_booking)->format('d/m/Y') }}</td>
                                <td>{{ $booking->jam_mulai }} - {{ $booking->jam_selesai }}</td>
                                <td>{{ $booking->kontak }}</td>
                                <td>
                                    <span class="badge {{ $booking->status == 'terkonfirmasi' ? 'bg-success' : 'bg-warning' }}">
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                </td>
                                <td>{{ $booking->deleted_at->format('d/m/Y H:i') }}</td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <form action="{{ route('booking.restore', $booking->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success" title="Pulihkan">
                                                <i class="fas fa-trash-restore"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route('booking.force-delete', $booking->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus permanen booking ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Hapus Permanen">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-end">
                {{ $deletedBookings->links() }}
            </div>
        @else
            <div class="alert alert-info">
                <i class="fas fa-info-circle me-2"></i>Tidak ada data booking yang dihapus.
            </div>
        @endif
    </div>
    <div class="card-footer">
        <a href="{{ route('booking.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i>Kembali ke Daftar Booking
        </a>
    </div>
</div>
@endsection