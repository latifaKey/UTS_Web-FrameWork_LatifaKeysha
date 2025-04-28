<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BookingController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Pengecekan apakah request merupakan pencarian
        $query = Booking::query();

        // Jika user bukan admin, hanya tampilkan booking miliknya
        if (Auth::user()->role !== 'admin') {
            $query->where('user_id', Auth::id());
        }

        if (request()->has('search')) {
            $search = request()->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_pemesan', 'like', '%' . $search . '%')
                  ->orWhere('jenis_lapangan', 'like', '%' . $search . '%')
                  ->orWhere('tanggal_booking', 'like', '%' . $search . '%')
                  ->orWhere('status', 'like', '%' . $search . '%');
            });
        }

        $bookings = $query->orderBy('created_at', 'desc')->paginate(7);

        return view('booking.index', compact('bookings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Prevent admin users from creating bookings
        if (Auth::user()->role === 'admin') {
            return redirect()->route('booking.index')
                ->with('error', 'Admin tidak diperbolehkan membuat booking baru. Silakan gunakan akun user.');
        }

        return view('booking.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Prevent admin users from creating bookings
        if (Auth::user()->role === 'admin') {
            return redirect()->route('booking.index')
                ->with('error', 'Admin tidak diperbolehkan membuat booking baru. Silakan gunakan akun user.');
        }

        $data = $request->all();

        // Explicit format for jam_mulai and jam_selesai before validation
        if (isset($data['jam_mulai'])) {
            $data['jam_mulai'] = substr($data['jam_mulai'], 0, 5);
            $request->merge(['jam_mulai' => $data['jam_mulai']]);
        }

        if (isset($data['jam_selesai'])) {
            $data['jam_selesai'] = substr($data['jam_selesai'], 0, 5);
            $request->merge(['jam_selesai' => $data['jam_selesai']]);
        }

        $validator = Validator::make($data, [
            'nama_pemesan' => 'required|string|max:255',
            'jenis_lapangan' => 'required|in:futsal,badminton,tenis',
            'tanggal_booking' => 'required|date|after_or_equal:today',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'kontak' => 'required|string|max:20',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Set status default ke pending dan tambahkan user_id
        $data['status'] = 'pending';
        $data['user_id'] = Auth::id();

        Booking::create($data);

        return redirect()->route('booking.index')
            ->with('success', 'Booking berhasil ditambahkan dan menunggu persetujuan admin.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $booking = Booking::findOrFail($id);

        // Jika bukan admin dan bukan booking miliknya, tolak akses
        if (Auth::user()->role !== 'admin' && $booking->user_id != Auth::id()) {
            abort(403, 'Anda tidak memiliki izin untuk melihat booking ini.');
        }

        return view('booking.show', compact('booking'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $booking = Booking::findOrFail($id);

        // Jika bukan admin dan bukan booking miliknya, tolak akses
        if (Auth::user()->role !== 'admin' && $booking->user_id != Auth::id()) {
            abort(403, 'Anda tidak memiliki izin untuk mengedit booking ini.');
        }

        // Jika sudah dikonfirmasi dan bukan admin, tolak akses edit
        if ($booking->status === 'terkonfirmasi' && Auth::user()->role !== 'admin') {
            return redirect()->route('booking.show', $booking->id)
                ->with('error', 'Booking yang sudah dikonfirmasi tidak dapat diedit. Silahkan hubungi admin.');
        }

        return view('booking.edit', compact('booking'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $booking = Booking::findOrFail($id);

        // Jika bukan admin dan bukan booking miliknya, tolak akses
        if (Auth::user()->role !== 'admin' && $booking->user_id != Auth::id()) {
            abort(403, 'Anda tidak memiliki izin untuk mengupdate booking ini.');
        }

        // Format waktu dari form ke format database
        $data = $request->all();

        // For non-admin users, ensure status stays the same
        if (Auth::user()->role !== 'admin') {
            // Override any status in the request with the current booking status
            $data['status'] = $booking->status;
            $request->merge(['status' => $booking->status]);
        }

        // Explicit format for jam_mulai and jam_selesai before validation
        if (isset($data['jam_mulai'])) {
            $data['jam_mulai'] = substr($data['jam_mulai'], 0, 5);
            $request->merge(['jam_mulai' => $data['jam_mulai']]);
        }

        if (isset($data['jam_selesai'])) {
            $data['jam_selesai'] = substr($data['jam_selesai'], 0, 5);
            $request->merge(['jam_selesai' => $data['jam_selesai']]);
        }

        // Validasi sesuai dengan role
        if (Auth::user()->role === 'admin') {
            $validator = Validator::make($data, [
                'nama_pemesan' => 'required|string|max:255',
                'jenis_lapangan' => 'required|in:futsal,badminton,tenis',
                'tanggal_booking' => 'required|date',
                'jam_mulai' => 'required|date_format:H:i',
                'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
                'kontak' => 'required|string|max:20',
                'status' => 'required|in:terkonfirmasi,pending',
            ]);
        } else {
            // Jika sudah dikonfirmasi dan bukan admin, tolak akses edit
            if ($booking->status === 'terkonfirmasi') {
                return redirect()->route('booking.show', $booking->id)
                    ->with('error', 'Booking yang sudah dikonfirmasi tidak dapat diedit. Silahkan hubungi admin.');
            }

            $validator = Validator::make($data, [
                'nama_pemesan' => 'required|string|max:255',
                'jenis_lapangan' => 'required|in:futsal,badminton,tenis',
                'tanggal_booking' => 'required|date|after_or_equal:today',
                'jam_mulai' => 'required|date_format:H:i',
                'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
                'kontak' => 'required|string|max:20',
            ]);
        }

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // User biasa tidak boleh mengubah status
        if (Auth::user()->role !== 'admin') {
            unset($data['status']);
        }

        $booking->update($data);

        return redirect()->route('booking.index')
            ->with('success', 'Booking berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $booking = Booking::findOrFail($id);
        $booking->delete();

        return redirect()->route('booking.index')
            ->with('success', 'Booking berhasil dihapus.');
    }

    /**
     * Display a listing of the deleted resources.
     */
    public function trash()
    {
        $deletedBookings = Booking::onlyTrashed()->latest()->paginate(7);
        return view('booking.trash', compact('deletedBookings'));
    }

    /**
     * Restore the specified deleted resource.
     */
    public function restore($id)
    {
        $booking = Booking::onlyTrashed()->findOrFail($id);
        $booking->restore();

        return redirect()->route('booking.trash')
            ->with('success', 'Booking berhasil dipulihkan.');
    }

    /**
     * Permanently delete the specified resource from storage.
     */
    public function forceDelete($id)
    {
        $booking = Booking::onlyTrashed()->findOrFail($id);
        $booking->forceDelete();

        return redirect()->route('booking.trash')
            ->with('success', 'Booking berhasil dihapus permanen.');
    }

    /**
     * Menyetujui booking dengan mengubah status menjadi terkonfirmasi
     */
    public function approve($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->status = 'terkonfirmasi';
        $booking->save();

        return redirect()->route('booking.index')
            ->with('success', 'Booking berhasil disetujui.');
    }

    /**
     * Menampilkan daftar booking yang menunggu persetujuan
     */
    public function pending()
    {
        $pendingBookings = Booking::where('status', 'pending')
            ->orderBy('tanggal_booking', 'asc')
            ->paginate(7);

        return view('booking.pending', compact('pendingBookings'));
    }
}
