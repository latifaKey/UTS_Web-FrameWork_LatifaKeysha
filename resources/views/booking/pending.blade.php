@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5><i class="fas fa-clock me-2"></i>Booking Menunggu Persetujuan</h5>
                    <a href="{{ route('booking.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left me-1"></i>
                    </a>
                </div>
                <div class="card-body">
                    @if($pendingBookings->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Pemesan</th>
                                        <th>Dibuat Oleh</th>
                                        <th>Jenis Lapangan</th>
                                        <th>Tanggal</th>
                                        <th>Waktu</th>
                                        <th>Kontak</th>
                                        <th>Status</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pendingBookings as $index => $booking)
                                        <tr>
                                            <td>{{ $pendingBookings->firstItem() + $index }}</td>
                                            <td>{{ $booking->nama_pemesan }}</td>
                                            <td>
                                                @if($booking->user)
                                                    {{ $booking->user->name }}
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge {{ $booking->jenis_lapangan == 'futsal' ? 'bg-primary' : ($booking->jenis_lapangan == 'badminton' ? 'bg-success' : 'bg-warning') }}">
                                                    {{ ucfirst($booking->jenis_lapangan) }}
                                                </span>
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($booking->tanggal_booking)->format('d/m/Y') }}</td>
                                            <td>{{ $booking->jam_mulai }} - {{ $booking->jam_selesai }}</td>
                                            <td>{{ $booking->kontak }}</td>
                                            <td>
                                                <span class="badge bg-warning">Pending</span>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('booking.show', $booking->id) }}" class="btn btn-sm btn-light" title="Detail">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <form action="{{ route('booking.approve', $booking->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-success" title="Setujui">
                                                            <i class="fas fa-check"></i>
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('booking.destroy', $booking->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menolak booking ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger" title="Tolak">
                                                            <i class="fas fa-times"></i>
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
                            {{ $pendingBookings->links() }}
                        </div>
                    @else
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>Tidak ada booking yang menunggu persetujuan.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection