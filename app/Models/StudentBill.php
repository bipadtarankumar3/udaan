<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudentBill extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'invoice_no',
        'student_id',
        'student_name',
        'student_phone',
        'student_email',
        'student_father_name',
        'course_name',
        'title',
        'amount',
        'discount',
        'tax_amount',
        'total_payable',
        'paid_amount',
        'due_amount',
        'payment_status',
        'payment_method',
        'transaction_id',
        'billing_date',
        'due_date',
        'paid_at',
        'notes',
        'created_by',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'discount' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'total_payable' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'due_amount' => 'decimal:2',
        'billing_date' => 'date',
        'due_date' => 'date',
        'paid_at' => 'datetime',
    ];

    /**
     * Auto-generate unique invoice number on creation if not provided.
     */
    protected static function booted()
    {
        static::creating(function ($bill) {
            if (empty($bill->invoice_no)) {
                $year = date('Y');
                $latest = self::withTrashed()
                    ->where('invoice_no', 'like', "UBILL-{$year}-%")
                    ->latest('id')
                    ->first();

                if ($latest && preg_match('/UBILL-\d{4}-(\d+)/', $latest->invoice_no, $matches)) {
                    $nextSeq = intval($matches[1]) + 1;
                } else {
                    $nextSeq = 1001;
                }

                $bill->invoice_no = sprintf("UBILL-%s-%04d", $year, $nextSeq);
            }

            // Ensure automatic calculation of due_amount and status
            $bill->recalculate();
        });

        static::updating(function ($bill) {
            $bill->recalculate();
        });
    }

    /**
     * Recalculate total_payable, due_amount, and payment_status
     */
    public function recalculate(): void
    {
        $this->total_payable = max(0, floatval($this->amount) - floatval($this->discount) + floatval($this->tax_amount));
        $this->paid_amount = max(0, floatval($this->paid_amount));
        $this->due_amount = max(0, $this->total_payable - $this->paid_amount);

        if ($this->payment_status !== 'cancelled') {
            if ($this->due_amount <= 0 && $this->total_payable > 0) {
                $this->payment_status = 'paid';
                if (!$this->paid_at) {
                    $this->paid_at = now();
                }
            } elseif ($this->paid_amount > 0 && $this->due_amount > 0) {
                $this->payment_status = 'partially_paid';
            } else {
                $this->payment_status = 'unpaid';
            }
        }
    }

    /**
     * Associated Student lead
     */
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    /**
     * Admin/Staff who generated the bill
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Convert number to words in Indian Rupees (e.g. for print receipt)
     */
    public function getAmountInWordsAttribute(): string
    {
        $number = round($this->total_payable);
        $no = floor($number);
        $point = round($number - $no, 2) * 100;
        $hundred = null;
        $digits_1 = strlen($no);
        $i = 0;
        $str = [];
        $words = [
            0 => '', 1 => 'One', 2 => 'Two', 3 => 'Three', 4 => 'Four', 5 => 'Five',
            6 => 'Six', 7 => 'Seven', 8 => 'Eight', 9 => 'Nine', 10 => 'Ten',
            11 => 'Eleven', 12 => 'Twelve', 13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen',
            16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen', 19 => 'Nineteen', 20 => 'Twenty',
            30 => 'Thirty', 40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty', 70 => 'Seventy',
            80 => 'Eighty', 90 => 'Ninety'
        ];
        $digits = ['', 'Hundred', 'Thousand', 'Lakh', 'Crore'];

        while ($i < $digits_1) {
            $divider = ($i == 2) ? 10 : 100;
            $number = floor($no % $divider);
            $no = floor($no / $divider);
            $i += ($divider == 10) ? 1 : 2;
            if ($number) {
                $plural = (($counter = count($str)) && $number > 9) ? '' : '';
                $hundred = ($counter == 1 && $str[0]) ? ' and ' : '';
                $str[] = ($number < 21) ? $words[$number] . " " . $digits[$counter] . $plural . " " . $hundred
                    : $words[floor($number / 10) * 10] . " " . $words[$number % 10] . " " . $digits[$counter] . $plural . " " . $hundred;
            } else {
                $str[] = null;
            }
        }
        $str = array_reverse($str);
        $result = implode('', $str);
        return trim($result) ? trim($result) . " Rupees Only" : "Zero Rupees";
    }
}
