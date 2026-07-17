<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataPayment extends Model
{
    use HasFactory;

    public const STATUS_PAID = 1;

    public const STATUS_PENDING = 2;

    public const STATUS_CANCELED = 99;

    public const PURCHASE_MEMBERSHIP = 'membership';

    public const PURCHASE_CLASS = 'kelas';

    public const PURCHASE_TYPE_MEMBERSHIP = 1;

    public const PURCHASE_TYPE_CLASS = 2;

    protected $table = 'datapayment';

    protected $fillable = [
        'no_invoice',
        'user_id',
        'class_id',
        'pembelian',
        'nominal',
        'expired',
        'qty',
        'status',
        'keterangan',
        'link_payment',
        'tipe_pembelian',
        'is_konfirmasi',
        'is_iht',
    ];

    protected $casts = [
        'user_id' => 'integer',
        'class_id' => 'integer',
        'nominal' => 'float',
        'expired' => 'integer',
        'qty' => 'float',
        'status' => 'integer',
        'tipe_pembelian' => 'integer',
        'is_konfirmasi' => 'integer',
        'is_iht' => 'integer',
    ];

    public function isIhtWithoutExpiry(): bool
    {
        return (int) $this->is_iht === 1 && $this->expired !== null && (int) $this->expired === 0;
    }

    public function isWaitingForIhtConfirmation(): bool
    {
        return $this->isIhtWithoutExpiry() && (int) $this->is_konfirmasi !== 1;
    }

    public function isConfirmedIhtWithoutExpiry(): bool
    {
        return $this->isIhtWithoutExpiry() && (int) $this->is_konfirmasi === 1;
    }

    public function canPayConfirmedIht(): bool
    {
        return (int) $this->is_iht === 1
            && (int) $this->is_konfirmasi === 1
            && (int) $this->status === self::STATUS_PENDING;
    }

    public function hasConfirmedIhtPaymentLink(): bool
    {
        return (int) $this->is_iht === 1
            && (int) $this->is_konfirmasi === 1
            && filled($this->link_payment)
            && (int) $this->expired > 0;
    }

    public function paymentExpiresAt()
    {
        if ((int) $this->expired < 1) {
            return null;
        }

        if ((int) $this->is_iht === 1 && (int) $this->is_konfirmasi === 1 && blank($this->link_payment)) {
            return null;
        }

        $startsAt = $this->hasConfirmedIhtPaymentLink() ? $this->updated_at : $this->created_at;

        return $startsAt ? $startsAt->copy()->addMinutes((int) $this->expired) : null;
    }

    public function billingStatus(): int
    {
        if ($this->isWaitingForIhtConfirmation()) {
            return self::STATUS_PENDING;
        }

        return (int) $this->status;
    }

    public function scopeWaitingForIhtConfirmation($query)
    {
        return $query
            ->where('is_iht', 1)
            ->where('expired', 0)
            ->where(function ($query) {
                $query->where('is_konfirmasi', '!=', 1)
                    ->orWhereNull('is_konfirmasi');
            });
    }

    public function scopeNotWaitingForIhtConfirmation($query)
    {
        return $query->where(function ($query) {
            $query->where('is_iht', '!=', 1)
                ->orWhereNull('is_iht')
                ->orWhere('expired', '!=', 0)
                ->orWhereNull('expired')
                ->orWhere('is_konfirmasi', 1);
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function paymentClass()
    {
        return $this->belongsTo(ClassesModel::class, 'class_id');
    }

    public function classPayment()
    {
        return $this->hasOne(ClassPaymentModel::class, 'no_invoice', 'no_invoice');
    }
}
