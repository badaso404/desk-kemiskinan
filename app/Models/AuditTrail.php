<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuditTrail extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'user_name',
        'action',
        'module',
        'description',
        'model_type',
        'model_id',
        'metadata',
    ];

    protected $casts = [
        'metadata' => 'array',
    ];

    public static function normalizeAction(string $action, string $module): string
    {
        $action = strtolower(trim($action));
        $module = strtolower(trim($module));

        if (in_array($action, ['login', 'logout'], true)) {
            return $action;
        }

        $aliases = [
            'store' => 'create',
            'create' => 'create',
            'add' => 'create',
            'edit' => 'update',
            'update' => 'update',
            'destroy' => 'delete',
            'delete' => 'delete',
            'remove' => 'delete',
        ];

        $normalizedAction = $aliases[$action] ?? $action;

        if (in_array($normalizedAction, ['create', 'update', 'delete'], true)) {
            return sprintf('%s_%s', $normalizedAction, $module);
        }

        return $normalizedAction;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function log(
        string $action,
        string $module,
        string $description,
        ?string $modelType = null,
        ?int $modelId = null,
        array $metadata = [],
        ?string $userName = null
    ): self {
        $user = auth()->user();
        $normalizedAction = self::normalizeAction($action, $module);

        return self::create([
            'user_id' => $user?->id,
            'user_name' => $userName ?? $user?->name ?? 'Sistem',
            'action' => $normalizedAction,
            'module' => $module,
            'description' => $description,
            'model_type' => $modelType,
            'model_id' => $modelId,
            'metadata' => $metadata,
        ]);
    }
}
