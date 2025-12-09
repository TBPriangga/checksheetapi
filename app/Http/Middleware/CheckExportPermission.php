<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckExportPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        // Check if user is authenticated
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. Please login first.'
            ], 401);
        }
                                          
        // Define export permissions per type
        $exportType = $this->getExportType($request);
        $allowedRoles = $this->getAllowedRoles($exportType);

        // Check if user has required role
        if (!$user->hasAnyRole($allowedRoles)) {
            return response()->json([
                'success' => false,
                'message' => 'Forbidden. You do not have permission to export this data.',
                'required_roles' => $allowedRoles
            ], 403);
        }

        return $next($request);
    }

    /**
     * Get export type from request
     */
    private function getExportType(Request $request): string
    {
        $path = $request->path();

        if (str_contains($path, 'monitoring-apar')) {
            return 'apar';
        } elseif (str_contains($path, 'template')) {
            return 'template';
        } else {
            return 'laporan';
        }
    }

    /**
     * Get allowed roles for export type
     */
    private function getAllowedRoles(string $type): array
    {
        return match($type) {
            'apar' => ['Admin', 'EHS', 'Departement Head EHS'],
            'template' => ['Admin', 'EHS', 'PIC', 'Departement Head PIC', 'Departement Head EHS'],
            'laporan' => ['Admin', 'EHS', 'PIC', 'Departement Head PIC', 'Departement Head EHS'],
            default => ['Admin', 'EHS'],
        };
    }
}