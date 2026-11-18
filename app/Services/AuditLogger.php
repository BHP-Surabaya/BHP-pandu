<?php

namespace App\Services;

use App\Models\AuditLog;
use App\Models\Permohonan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class AuditLogger
{
    /**
     * Catat aktivitas audit log secara aman dan terstruktur untuk forensik hukum.
     *
     * @param  array<string, mixed>  $details
     */
    public static function log(
        string $action,
        ?Permohonan $permohonan = null,
        ?string $description = null,
        ?Model $resource = null,
        array $details = []
    ): AuditLog {
        $user = Auth::user();
        $request = request();

        $resourceType = $resource ? class_basename($resource) : ($permohonan ? 'Permohonan' : null);
        $resourceId = $resource?->getKey() ?? $permohonan?->getKey();

        if (empty($description)) {
            $userName = $user ? "{$user->name} ({$user->role})" : 'Sistem';
            $permohonanNo = $permohonan ? " pada permohonan {$permohonan->nomor_permohonan}" : '';
            $description = "Aktivitas {$action} dilakukan oleh {$userName}{$permohonanNo}.";
        }

        return AuditLog::create([
            'user_id' => $user?->id,
            'permohonan_id' => $permohonan?->id,
            'action' => $action,
            'resource_type' => $resourceType ? strtolower($resourceType) : null,
            'resource_id' => $resourceId,
            'description' => $description,
            'ip_address' => $request?->ip(),
            'user_agent' => $request?->userAgent(),
            'details' => $details,
        ]);
    }
}
