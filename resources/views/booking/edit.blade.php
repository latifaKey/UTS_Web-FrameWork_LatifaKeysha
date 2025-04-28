@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0"><i class="fas fa-edit me-2"></i>Edit Booking</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('booking.update', $booking->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="nama_pemesan" class="form-label">Nama Pemesan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nama_pemesan') is-invalid @enderror" id="nama_pemesan" name="nama_pemesan" value="{{ old('nama_pemesan', $booking->nama_pemesan) }}" required>
                        @error('nama_pemesan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="jenis_lapangan" class="form-label">Jenis Lapangan <span class="text-danger">*</span></label>
                        <select class="form-select @error('jenis_lapangan') is-invalid @enderror" id="jenis_lapangan" name="jenis_lapangan" required>
                            <option value="">Pilih Jenis Lapangan</option>
                            <option value="futsal" {{ old('jenis_lapangan', $booking->jenis_lapangan) == 'futsal' ? 'selected' : '' }}>Futsal</option>
                            <option value="badminton" {{ old('jenis_lapangan', $booking->jenis_lapangan) == 'badminton' ? 'selected' : '' }}>Badminton</option>
                            <option value="tenis" {{ old('jenis_lapangan', $booking->jenis_lapangan) == 'tenis' ? 'selected' : '' }}>Tenis</option>
                        </select>
                        @error('jenis_lapangan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="tanggal_booking" class="form-label">Tanggal Booking <span class="text-danger">*</span></label>
                        <input type="date" class="form-control @error('tanggal_booking') is-invalid @enderror" id="tanggal_booking" name="tanggal_booking" value="{{ old('tanggal_booking', $booking->tanggal_booking) }}" required>
                        @error('tanggal_booking')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="jam_mulai" class="form-label">Jam Mulai <span class="text-danger">*</span></label>
                        <input type="time" class="form-control @error('jam_mulai') is-invalid @enderror" id="jam_mulai" name="jam_mulai" value="{{ old('jam_mulai', substr($booking->jam_mulai, 0, 5)) }}" required step="60">
                        @error('jam_mulai')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="jam_selesai" class="form-label">Jam Selesai <span class="text-danger">*</span></label>
                        <input type="time" class="form-control @error('jam_selesai') is-invalid @enderror" id="jam_selesai" name="jam_selesai" value="{{ old('jam_selesai', substr($booking->jam_selesai, 0, 5)) }}" required step="60">
                        @error('jam_selesai')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="kontak" class="form-label">Kontak (Telepon/HP) <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('kontak') is-invalid @enderror" id="kontak" name="kontak" value="{{ old('kontak', $booking->kontak) }}" required>
                        @error('kontak')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    @if(Auth::user()->role === 'admin')
                    <div class="mb-3">
                        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                        <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                            <option value="pending" {{ old('status', $booking->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="terkonfirmasi" {{ old('status', $booking->status) == 'terkonfirmasi' ? 'selected' : '' }}>Terkonfirmasi</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    @else
                    <div class="mb-3">
                        <label for="status_display" class="form-label">Status</label>
                        <div class="form-control bg-light">
                            @if($booking->status == 'pending')
                                <span class="badge bg-warning text-dark">Pending</span>
                            @else
                                <span class="badge bg-success">Terkonfirmasi</span>
                            @endif
                        </div>
                        <input type="hidden" name="status" value="{{ $booking->status }}">
                    </div>
                    @endif
                </div>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('booking.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i>Kembali
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i>Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Format time inputs to ensure they're in H:i format
    const timeInputs = document.querySelectorAll('input[type="time"]');

    timeInputs.forEach(input => {
        input.addEventListener('change', function() {
            // Ensure time format is H:i by trimming seconds if present
            if (this.value.length > 5) {
                this.value = this.value.substring(0, 5);
            }
        });
    });

    // Handle form submission to ensure time formats are correct
    document.querySelector('form').addEventListener('submit', function(e) {
        timeInputs.forEach(input => {
            if (input.value.length > 5) {
                input.value = input.value.substring(0, 5);
            }
        });
    });
});
</script>
@endpush
