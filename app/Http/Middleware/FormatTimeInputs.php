<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FormatTimeInputs
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Format time fields to H:i format
        if ($request->has('jam_mulai')) {
            // Extract only HH:MM part from the time string
            $jam_mulai = $request->input('jam_mulai');
            if (strlen($jam_mulai) > 5) {
                $request->merge(['jam_mulai' => substr($jam_mulai, 0, 5)]);
            }
        }

        if ($request->has('jam_selesai')) {
            // Extract only HH:MM part from the time string
            $jam_selesai = $request->input('jam_selesai');
            if (strlen($jam_selesai) > 5) {
                $request->merge(['jam_selesai' => substr($jam_selesai, 0, 5)]);
            }
        }

        return $next($request);
    }
}
