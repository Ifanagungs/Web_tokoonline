<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'order_number',
        'recipient_name',
        'recipient_phone',
        'shipping_address',
        'subtotal',
        'shipping_cost',
        'total',
        'payment_method',
        'status',
        'notes',
        'payment_receipt',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Generate unique order number: TBT-YYYYMMDD-XXXXX
     */
    public static function generateOrderNumber(): string
    {
        $date = now()->format('Ymd');
        $random = strtoupper(substr(uniqid(), -5));
        $orderNumber = "TBT-{$date}-{$random}";

        while (self::where('order_number', $orderNumber)->exists()) {
            $random = strtoupper(substr(uniqid(), -5));
            $orderNumber = "TBT-{$date}-{$random}";
        }

        return $orderNumber;
    }

    /**
     * Get formatted total.
     */
    public function getFormattedTotalAttribute(): string
    {
        return 'Rp ' . number_format($this->total, 0, ',', '.');
    }

    /**
     * Get formatted subtotal.
     */
    public function getFormattedSubtotalAttribute(): string
    {
        return 'Rp ' . number_format($this->subtotal, 0, ',', '.');
    }

    /**
     * Get formatted shipping cost.
     */
    public function getFormattedShippingCostAttribute(): string
    {
        return 'Rp ' . number_format($this->shipping_cost, 0, ',', '.');
    }

    /**
     * Get status label in Indonesian.
     */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending_payment' => 'Menunggu Pembayaran',
            'processing' => 'Diproses',
            'shipped' => 'Sedang Dikirim',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
            default => $this->status,
        };
    }

    /**
     * Get status color class.
     */
    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'pending_payment' => 'bg-yellow-100 text-yellow-800',
            'processing' => 'bg-blue-100 text-blue-800',
            'shipped' => 'bg-purple-100 text-purple-800',
            'completed' => 'bg-green-100 text-green-800',
            'cancelled' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    /**
     * Get payment method label.
     */
    public function getPaymentMethodLabelAttribute(): string
    {
        return match ($this->payment_method) {
            'transfer_bank' => 'Transfer Bank',
            'cod' => 'COD (Bayar di Tempat)',
            default => $this->payment_method,
        };
    }

    /**
     * Get payment receipt URL.
     */
    public function getPaymentReceiptUrlAttribute(): ?string
    {
        return $this->payment_receipt ? asset('storage/' . $this->payment_receipt) : null;
    }
}
