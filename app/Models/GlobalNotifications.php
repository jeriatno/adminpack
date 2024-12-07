<?php

namespace App\Models;

use App\Models\Traits\UsesUuid;
use App\Repositories\ForwardOrder\ForwardOrderRepository;
use App\Repositories\Pipeline\PipelineHeaderRepository;
use App\Repositories\PrincipalClaim\PrincipalClaimRepository;
use App\Repositories\RentStock\RentStockSPPBRepository;
use App\User;
use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;

class GlobalNotifications extends Model
{
    use CrudTrait, UsesUuid, SoftDeletes;

    protected $table = 'global_notifications';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $guarded = [];

    public static $repo = [
        'po_booking'        => ForwardOrderRepository::class,
        'principal_claim'   => PrincipalClaimRepository::class,
        'pipeline'          => PipelineHeaderRepository::class,
        'rent_stock_sppb'   => RentStockSPPBRepository::class,
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->{$model->getKeyName()} = (string) Uuid::uuid4();
        });
    }

    public function notifiable(): BelongsTo
    {
        return $this->belongsTo(User::class, 'notifiable_id', 'id');
    }

    public function notifier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'notifier_id', 'id');
    }
}
