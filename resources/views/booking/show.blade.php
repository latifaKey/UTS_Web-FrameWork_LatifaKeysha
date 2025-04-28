@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Detail Booking</h5>
        @if(Auth::user()->role === 'admin')
        <div>
            <a href="{{ route('booking.edit', $booking->id) }}" class="btn btn-warning btn-sm">
                <i class="fas fa-edit me-1"></i>Edit
            </a>
            <form action="{{ route('booking.destroy', $booking->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus booking ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm">
                    <i class="fas fa-trash-alt me-1"></i>Hapus
                </button>
            </form>
        </div>
        @endif
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <table class="table table-borderless">
                    <tr>
                        <th width="35%">ID Booking</th>
                        <td width="5%">:</td>
                        <td>{{ $booking->id }}</td>
                    </tr>
                    <tr>
                        <th>Nama Pemesan</th>
                        <td>:</td>
                        <td>{{ $booking->nama_pemesan }}</td>
                    </tr>
                    @if(Auth::user()->role === 'admin')
                    <tr>
                        <th>Dibuat Oleh</th>
                        <td>:</td>
                        <td>
                            @if($booking->user)
                                {{ $booking->user->name }} ({{ $booking->user->email }})
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                    </tr>
                    @endif
                    <tr>
                        <th>Jenis Lapangan</th>
                        <td>:</td>
                        <td>
                            <span class="badge {{ $booking->jenis_lapangan == 'futsal' ? 'bg-primary' : ($booking->jenis_lapangan == 'badminton' ? 'bg-success' : 'bg-warning') }}">
                                {{ ucfirst($booking->jenis_lapangan) }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Kontak</th>
                        <td>:</td>
                        <td>{{ $booking->kontak }}</td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table table-borderless">
                    <tr>
                        <th width="35%">Tanggal Booking</th>
                        <td width="5%">:</td>
                        <td>{{ \Carbon\Carbon::parse($booking->tanggal_booking)->format('d/m/Y') }}</td>
                    </tr>
                    <tr>
                        <th>Jam</th>
                        <td>:</td>
                        <td>{{ $booking->jam_mulai }} - {{ $booking->jam_selesai }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>:</td>
                        <td>
                            <span class="badge {{ $booking->status == 'terkonfirmasi' ? 'bg-success' : 'bg-warning' }}">
                                {{ ucfirst($booking->status) }}
                            </span>
                            @if(Auth::user()->role === 'admin' && $booking->status == 'pending')
                            <form action="{{ route('booking.approve', $booking->id) }}" method="POST" class="d-inline ms-2">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-success">
                                    <i class="fas fa-check me-1"></i>Setujui
                                </button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Tanggal Dibuat</th>
                        <td>:</td>
                        <td>{{ $booking->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <a href="{{ route('booking.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i>Kembali
        </a>
    </div>
</div>
@endsection