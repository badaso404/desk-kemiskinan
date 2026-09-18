<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditTrail;
use Illuminate\Http\Request;

class AuditTrailController extends Controller
{
    public function index(Request $request)
    {
        $query = AuditTrail::query()->latest();

        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('action', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('user_name', 'like', "%{$search}%");
            });
        }

        if ($request->filled('event') && $request->event !== 'all') {
            $query->where('action', $request->event);
        }

        $auditTrails = $query->paginate(15)->withQueryString();

        $eventOptions = [
            ['value' => 'all', 'label' => 'Semua Event'],
            ['value' => 'login', 'label' => 'login'],
            ['value' => 'logout', 'label' => 'logout'],
            ['value' => 'create_masyarakat', 'label' => 'create_masyarakat'],
            ['value' => 'update_masyarakat', 'label' => 'update_masyarakat'],
            ['value' => 'delete_masyarakat', 'label' => 'delete_masyarakat'],
            ['value' => 'create_program', 'label' => 'create_program'],
            ['value' => 'update_program', 'label' => 'update_program'],
            ['value' => 'delete_program', 'label' => 'delete_program'],
            ['value' => 'create_mitra', 'label' => 'create_mitra'],
            ['value' => 'update_mitra', 'label' => 'update_mitra'],
            ['value' => 'delete_mitra', 'label' => 'delete_mitra'],
            ['value' => 'create_penempatan', 'label' => 'create_penempatan'],
            ['value' => 'update_penempatan', 'label' => 'update_penempatan'],
            ['value' => 'status_change', 'label' => 'status_change'],
            ['value' => 'permission_change', 'label' => 'permission_change'],
        ];

        return view('admin.audit-trail.index', [
            'auditTrails' => $auditTrails,
            'eventOptions' => $eventOptions,
        ]);
    }
}
