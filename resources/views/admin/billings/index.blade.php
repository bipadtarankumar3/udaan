@extends('layouts.app')

@section('title', 'Student Billing & Fee Management')
@section('header', 'Student Billing & Fee Receipts')

@section('content')
<div class="space-y-6" x-data="{
    createModalOpen: false,
    editModalOpen: false,
    payModalOpen: false,
    deleteModalOpen: false,
    studentsList: {{ Js::from($students) }},
    
    // Create Bill Form State
    newBill: {
        student_id: '',
        student_name: '',
        student_phone: '',
        student_email: '',
        student_father_name: '',
        course_name: '',
        title: 'Admission Counselling & Registration Fee',
        amount: 0,
        discount: 0,
        tax_amount: 0,
        paid_amount: 0,
        payment_method: 'Cash',
        transaction_id: '',
        billing_date: '{{ date('Y-m-d') }}',
        due_date: '{{ date('Y-m-d', strtotime('+7 days')) }}',
        notes: ''
    },

    // Edit Bill Form State
    currentBill: {
        id: null,
        invoice_no: '',
        student_id: '',
        student_name: '',
        student_phone: '',
        student_email: '',
        student_father_name: '',
        course_name: '',
        title: '',
        amount: 0,
        discount: 0,
        tax_amount: 0,
        paid_amount: 0,
        payment_status: 'unpaid',
        payment_method: 'Cash',
        transaction_id: '',
        billing_date: '',
        due_date: '',
        notes: ''
    },

    // Pay Modal State
    activePayBill: {
        id: null,
        invoice_no: '',
        student_name: '',
        total_payable: 0,
        paid_amount: 0,
        due_amount: 0,
        payment_amount: 0,
        payment_method: 'UPI / QR Code',
        transaction_id: '',
        payment_date: '{{ date('Y-m-d') }}',
        notes: ''
    },

    // Delete Modal State
    billToDelete: { id: null, invoice_no: '', student_name: '', amount: 0 },

    // Methods
    onStudentSelect(studentId) {
        if (!studentId) return;
        const st = this.studentsList.find(s => s.id == studentId);
        if (st) {
            this.newBill.student_name = st.name || '';
            this.newBill.student_phone = st.phone || '';
            this.newBill.student_email = st.email || '';
            this.newBill.student_father_name = st.father_name || '';
            this.newBill.course_name = st.course_interested || '';
        }
    },

    calcTotal(amount, discount, tax) {
        return Math.max(0, (parseFloat(amount) || 0) - (parseFloat(discount) || 0) + (parseFloat(tax) || 0));
    },

    calcDue(amount, discount, tax, paid) {
        const total = this.calcTotal(amount, discount, tax);
        return Math.max(0, total - (parseFloat(paid) || 0));
    },

    openEditModal(bill) {
        this.currentBill = {
            id: bill.id,
            invoice_no: bill.invoice_no,
            student_id: bill.student_id || '',
            student_name: bill.student_name,
            student_phone: bill.student_phone,
            student_email: bill.student_email || '',
            student_father_name: bill.student_father_name || '',
            course_name: bill.course_name || '',
            title: bill.title,
            amount: parseFloat(bill.amount) || 0,
            discount: parseFloat(bill.discount) || 0,
            tax_amount: parseFloat(bill.tax_amount) || 0,
            paid_amount: parseFloat(bill.paid_amount) || 0,
            payment_status: bill.payment_status,
            payment_method: bill.payment_method || 'Cash',
            transaction_id: bill.transaction_id || '',
            billing_date: bill.billing_date ? bill.billing_date.substring(0, 10) : '',
            due_date: bill.due_date ? bill.due_date.substring(0, 10) : '',
            notes: bill.notes || ''
        };
        this.editModalOpen = true;
    },

    openPayModal(bill) {
        const due = Math.max(0, parseFloat(bill.total_payable) - parseFloat(bill.paid_amount));
        this.activePayBill = {
            id: bill.id,
            invoice_no: bill.invoice_no,
            student_name: bill.student_name,
            total_payable: parseFloat(bill.total_payable),
            paid_amount: parseFloat(bill.paid_amount),
            due_amount: due,
            payment_amount: due,
            payment_method: 'UPI / QR Code',
            transaction_id: '',
            payment_date: '{{ date('Y-m-d') }}',
            notes: ''
        };
        this.payModalOpen = true;
    },

    openDeleteModal(bill) {
        this.billToDelete = {
            id: bill.id,
            invoice_no: bill.invoice_no,
            student_name: bill.student_name,
            amount: bill.total_payable
        };
        this.deleteModalOpen = true;
    }
}">

    <!-- Top Action Header & Quick KPI Metrics -->
    <div class="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-sm space-y-5">
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2">
                    <span class="px-2.5 py-0.5 rounded-md bg-red-50 text-red-700 border border-red-200 text-[10px] font-bold uppercase tracking-wider">
                        Finance & Accounts
                    </span>
                    <span class="text-xs text-slate-400">•</span>
                    <span class="text-xs text-slate-500 font-medium">Bihar Students Counseling Center</span>
                </div>
                <h3 class="text-lg font-bold font-heading text-slate-900 flex items-center gap-2 mt-1">
                    <i class="fa-solid fa-file-invoice-dollar text-red-600"></i>
                    <span>Student Billing & Fee Receipt Management</span>
                </h3>
                <p class="text-xs text-slate-500 mt-0.5">Generate official fee invoices, track payments, manage collections, and print money receipts</p>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center flex-wrap gap-2.5">
                <a 
                    href="{{ route('admin.billings.export-csv', request()->query()) }}" 
                    class="px-3.5 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 border border-slate-200 rounded-xl text-xs font-semibold flex items-center gap-1.5 transition"
                    title="Export filtered billing transactions"
                >
                    <i class="fa-solid fa-file-csv text-emerald-600"></i>
                    <span>Export Ledger</span>
                </a>

                <button 
                    type="button" 
                    @click="createModalOpen = true"
                    class="px-4 py-2 bg-gradient-to-r from-red-600 via-orange-600 to-amber-600 hover:from-red-700 hover:to-orange-700 text-white rounded-xl text-xs font-bold shadow-md shadow-red-500/20 flex items-center gap-2 transition"
                >
                    <i class="fa-solid fa-plus"></i>
                    <span>Generate New Bill</span>
                </button>
            </div>
        </div>

        <!-- 4 Key Financial Metric Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 pt-2">
            <!-- 1. Total Invoiced -->
            <div class="bg-gradient-to-br from-slate-50 to-white border border-slate-200/80 rounded-xl p-4 shadow-sm relative overflow-hidden">
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500">Total Invoiced</span>
                    <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center text-sm">
                        <i class="fa-solid fa-receipt"></i>
                    </div>
                </div>
                <div class="mt-2 flex items-baseline gap-2">
                    <span class="text-2xl font-black text-slate-900">₹{{ number_format($metrics['total_invoiced'], 2) }}</span>
                </div>
                <div class="mt-1 text-[11px] text-slate-500 flex items-center gap-1.5">
                    <span class="font-bold text-slate-700">{{ $metrics['total_bills'] }}</span> total bills issued
                </div>
                <div class="absolute bottom-0 left-0 right-0 h-1 bg-blue-500"></div>
            </div>

            <!-- 2. Total Collected / Paid -->
            <div class="bg-gradient-to-br from-emerald-50/50 to-white border border-emerald-100 rounded-xl p-4 shadow-sm relative overflow-hidden">
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-bold uppercase tracking-wider text-emerald-700">Total Collected</span>
                    <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center text-sm">
                        <i class="fa-solid fa-circle-check"></i>
                    </div>
                </div>
                <div class="mt-2 flex items-baseline gap-2">
                    <span class="text-2xl font-black text-emerald-700">₹{{ number_format($metrics['total_paid'], 2) }}</span>
                </div>
                <div class="mt-1 text-[11px] text-emerald-600 flex items-center gap-1.5 font-medium">
                    <span>{{ $metrics['paid_count'] }} fully paid</span>
                    <span>•</span>
                    <span>{{ $metrics['partial_count'] }} partial</span>
                </div>
                <div class="absolute bottom-0 left-0 right-0 h-1 bg-emerald-500"></div>
            </div>

            <!-- 3. Total Due / Pending -->
            <div class="bg-gradient-to-br from-amber-50/50 to-white border border-amber-100 rounded-xl p-4 shadow-sm relative overflow-hidden">
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-bold uppercase tracking-wider text-amber-700">Outstanding Due</span>
                    <div class="w-8 h-8 rounded-lg bg-amber-100 text-amber-700 flex items-center justify-center text-sm">
                        <i class="fa-solid fa-clock-rotate-left"></i>
                    </div>
                </div>
                <div class="mt-2 flex items-baseline gap-2">
                    <span class="text-2xl font-black text-amber-700">₹{{ number_format($metrics['total_due'], 2) }}</span>
                </div>
                <div class="mt-1 text-[11px] text-amber-600 flex items-center gap-1.5 font-medium">
                    <span>{{ $metrics['unpaid_count'] }} unpaid bills</span>
                </div>
                <div class="absolute bottom-0 left-0 right-0 h-1 bg-amber-500"></div>
            </div>

            <!-- 4. Collection Efficiency -->
            @php
                $collectionRate = $metrics['total_invoiced'] > 0 
                    ? round(($metrics['total_paid'] / $metrics['total_invoiced']) * 100, 1) 
                    : 0;
            @endphp
            <div class="bg-gradient-to-br from-purple-50/50 to-white border border-purple-100 rounded-xl p-4 shadow-sm relative overflow-hidden">
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-bold uppercase tracking-wider text-purple-700">Collection Rate</span>
                    <div class="w-8 h-8 rounded-lg bg-purple-100 text-purple-700 flex items-center justify-center text-sm">
                        <i class="fa-solid fa-percent"></i>
                    </div>
                </div>
                <div class="mt-2 flex items-baseline gap-2">
                    <span class="text-2xl font-black text-purple-800">{{ $collectionRate }}%</span>
                </div>
                <div class="mt-1 w-full bg-slate-100 rounded-full h-1.5 overflow-hidden">
                    <div class="bg-purple-600 h-1.5 rounded-full" style="width: {{ min(100, $collectionRate) }}%"></div>
                </div>
                <div class="absolute bottom-0 left-0 right-0 h-1 bg-purple-500"></div>
            </div>
        </div>
    </div>

    <!-- Filters & Search Bar -->
    <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-sm">
        <form action="{{ route('admin.billings.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-3 items-center">
            
            <!-- Search Input -->
            <div class="lg:col-span-4 relative">
                <i class="fa-solid fa-search absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}" 
                    placeholder="Search invoice #, student name, phone, UTR, course..." 
                    class="w-full pl-9 pr-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:bg-white focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition"
                >
            </div>

            <!-- Status Filter -->
            <div class="lg:col-span-2">
                <select 
                    name="status" 
                    class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:bg-white focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition"
                >
                    <option value="all" {{ request('status') === 'all' || !request('status') ? 'selected' : '' }}>All Statuses</option>
                    <option value="paid" {{ request('status') === 'paid' ? 'selected' : '' }}>Paid (Cleared)</option>
                    <option value="partially_paid" {{ request('status') === 'partially_paid' ? 'selected' : '' }}>Partially Paid</option>
                    <option value="unpaid" {{ request('status') === 'unpaid' ? 'selected' : '' }}>Unpaid / Due</option>
                    <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>

            <!-- Payment Method Filter -->
            <div class="lg:col-span-2">
                <select 
                    name="payment_method" 
                    class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:bg-white focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition"
                >
                    <option value="all">All Payment Modes</option>
                    <option value="Cash" {{ request('payment_method') === 'Cash' ? 'selected' : '' }}>Cash</option>
                    <option value="UPI / QR Code" {{ request('payment_method') === 'UPI / QR Code' ? 'selected' : '' }}>UPI / QR Code</option>
                    <option value="Net Banking" {{ request('payment_method') === 'Net Banking' ? 'selected' : '' }}>Net Banking</option>
                    <option value="Debit / Credit Card" {{ request('payment_method') === 'Debit / Credit Card' ? 'selected' : '' }}>Card</option>
                    <option value="DRCC Bihar Credit Card" {{ request('payment_method') === 'DRCC Bihar Credit Card' ? 'selected' : '' }}>DRCC Credit Card</option>
                    <option value="Cheque" {{ request('payment_method') === 'Cheque' ? 'selected' : '' }}>Cheque</option>
                </select>
            </div>

            <!-- Date From -->
            <div class="lg:col-span-2">
                <input 
                    type="date" 
                    name="date_from" 
                    value="{{ request('date_from') }}" 
                    class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:bg-white focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition text-slate-600"
                    title="From billing date"
                >
            </div>

            <!-- Submit & Reset Buttons -->
            <div class="lg:col-span-2 flex items-center gap-2">
                <button 
                    type="submit" 
                    class="flex-1 px-3 py-2 bg-slate-900 hover:bg-slate-800 text-white rounded-xl text-xs font-semibold transition flex items-center justify-center gap-1.5"
                >
                    <i class="fa-solid fa-filter text-[10px]"></i>
                    <span>Filter</span>
                </button>
                @if(request()->anyFilled(['search', 'status', 'payment_method', 'date_from', 'student_id']))
                    <a 
                        href="{{ route('admin.billings.index') }}" 
                        class="px-2.5 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-xs transition"
                        title="Clear all filters"
                    >
                        <i class="fa-solid fa-rotate-left"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Bills & Invoices Data Table -->
    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-[11px] font-bold uppercase tracking-wider text-slate-500">
                        <th class="py-3 px-4">Invoice # &amp; Date</th>
                        <th class="py-3 px-4">Student &amp; Contact</th>
                        <th class="py-3 px-4">Purpose / Course</th>
                        <th class="py-3 px-4 text-right">Total Payable</th>
                        <th class="py-3 px-4 text-right">Paid / Due</th>
                        <th class="py-3 px-4 text-center">Status</th>
                        <th class="py-3 px-4">Payment Mode</th>
                        <th class="py-3 px-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs text-slate-700">
                    @forelse($bills as $bill)
                        <tr class="hover:bg-slate-50/70 transition">
                            
                            <!-- Invoice # & Date -->
                            <td class="py-3.5 px-4">
                                <div class="font-mono font-bold text-slate-900">
                                    <a href="{{ route('admin.billings.show', $bill) }}" class="text-blue-600 hover:underline flex items-center gap-1">
                                        <span>{{ $bill->invoice_no }}</span>
                                        <i class="fa-solid fa-arrow-up-right-from-square text-[10px] opacity-70"></i>
                                    </a>
                                </div>
                                <div class="text-[11px] text-slate-500 mt-0.5 flex items-center gap-1">
                                    <i class="fa-regular fa-calendar text-[10px]"></i>
                                    <span>{{ $bill->billing_date?->format('d M Y') }}</span>
                                </div>
                            </td>

                            <!-- Student & Contact -->
                            <td class="py-3.5 px-4">
                                <div class="font-bold text-slate-900 flex items-center gap-1.5">
                                    <span>{{ $bill->student_name }}</span>
                                    @if($bill->student_id)
                                        <a href="{{ route('admin.students.index', ['search' => $bill->student_phone]) }}" title="View in leads" class="text-orange-600 hover:text-orange-700">
                                            <i class="fa-solid fa-user-graduate text-[10px]"></i>
                                        </a>
                                    @endif
                                </div>
                                <div class="text-[11px] text-slate-500 flex items-center gap-2 mt-0.5">
                                    <span><i class="fa-solid fa-phone text-[9px] text-slate-400"></i> {{ $bill->student_phone }}</span>
                                    @if($bill->student_father_name)
                                        <span>• F: {{ $bill->student_father_name }}</span>
                                    @endif
                                </div>
                            </td>

                            <!-- Purpose & Course -->
                            <td class="py-3.5 px-4">
                                <div class="font-medium text-slate-800 line-clamp-1" title="{{ $bill->title }}">
                                    {{ $bill->title }}
                                </div>
                                @if($bill->course_name)
                                    <div class="text-[11px] text-orange-700 font-semibold mt-0.5">
                                        <i class="fa-solid fa-book-open text-[9px]"></i> {{ $bill->course_name }}
                                    </div>
                                @endif
                            </td>

                            <!-- Total Payable -->
                            <td class="py-3.5 px-4 text-right">
                                <div class="font-black text-slate-900 text-sm">
                                    ₹{{ number_format($bill->total_payable, 2) }}
                                </div>
                                @if($bill->discount > 0)
                                    <div class="text-[10.5px] text-emerald-600">
                                        Disc: -₹{{ number_format($bill->discount, 2) }}
                                    </div>
                                @endif
                            </td>

                            <!-- Paid / Due -->
                            <td class="py-3.5 px-4 text-right">
                                <div class="font-bold text-emerald-700">
                                    ₹{{ number_format($bill->paid_amount, 2) }} <span class="text-[10px] text-emerald-600 font-normal">paid</span>
                                </div>
                                @if($bill->due_amount > 0)
                                    <div class="text-[11px] font-bold text-amber-700 mt-0.5">
                                        ₹{{ number_format($bill->due_amount, 2) }} <span class="text-[10px] font-normal text-amber-600">due</span>
                                    </div>
                                @else
                                    <div class="text-[10px] text-slate-400 font-medium mt-0.5">
                                        No balance
                                    </div>
                                @endif
                            </td>

                            <!-- Status Badge -->
                            <td class="py-3.5 px-4 text-center">
                                @if($bill->payment_status === 'paid')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10.5px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        <i class="fa-solid fa-circle-check text-[9px]"></i> PAID
                                    </span>
                                @elseif($bill->payment_status === 'partially_paid')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10.5px] font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                        <i class="fa-solid fa-clock-rotate-left text-[9px]"></i> PARTIAL
                                    </span>
                                @elseif($bill->payment_status === 'cancelled')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10.5px] font-bold bg-slate-100 text-slate-600 border border-slate-200">
                                        <i class="fa-solid fa-ban text-[9px]"></i> CANCELLED
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10.5px] font-bold bg-rose-50 text-rose-700 border border-rose-200">
                                        <i class="fa-solid fa-circle-exclamation text-[9px]"></i> UNPAID
                                    </span>
                                @endif
                            </td>

                            <!-- Payment Mode & Ref -->
                            <td class="py-3.5 px-4">
                                <div class="font-medium text-slate-800">
                                    {{ $bill->payment_method ?: 'Not Specified' }}
                                </div>
                                @if($bill->transaction_id)
                                    <div class="text-[10px] font-mono text-slate-500 mt-0.5" title="Transaction ID / UTR">
                                        Ref: {{ $bill->transaction_id }}
                                    </div>
                                @endif
                            </td>

                            <!-- Actions -->
                            <td class="py-3.5 px-4 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end gap-1.5">
                                    
                                    <!-- Print / View Receipt -->
                                    <a 
                                        href="{{ route('admin.billings.show', $bill) }}" 
                                        target="_blank"
                                        class="p-1.5 rounded-lg bg-blue-50 text-blue-700 hover:bg-blue-100 transition"
                                        title="Print Official Receipt & Invoice"
                                    >
                                        <i class="fa-solid fa-print"></i>
                                    </a>

                                    <!-- Quick Record Payment (If not fully paid) -->
                                    @if($bill->due_amount > 0 && $bill->payment_status !== 'cancelled')
                                        <button 
                                            type="button" 
                                            @click="openPayModal({{ Js::from($bill) }})"
                                            class="p-1.5 rounded-lg bg-emerald-50 text-emerald-700 hover:bg-emerald-100 transition"
                                            title="Record Payment"
                                        >
                                            <i class="fa-solid fa-hand-holding-dollar"></i>
                                        </button>
                                    @endif

                                    <!-- Edit Bill -->
                                    <button 
                                        type="button" 
                                        @click="openEditModal({{ Js::from($bill) }})"
                                        class="p-1.5 rounded-lg bg-slate-100 text-slate-700 hover:bg-slate-200 transition"
                                        title="Edit Bill Details"
                                    >
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>

                                    <!-- Delete Bill -->
                                    <button 
                                        type="button" 
                                        @click="openDeleteModal({{ Js::from($bill) }})"
                                        class="p-1.5 rounded-lg bg-rose-50 text-rose-700 hover:bg-rose-100 transition"
                                        title="Delete Invoice"
                                    >
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-12 px-4 text-center">
                                <div class="w-12 h-12 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3 text-lg">
                                    <i class="fa-solid fa-file-invoice"></i>
                                </div>
                                <h4 class="text-sm font-bold text-slate-800">No Student Invoices Found</h4>
                                <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto">
                                    There are currently no billing records matching your search filters. Click "+ Generate New Bill" to create your first fee invoice.
                                </p>
                                <button 
                                    type="button" 
                                    @click="createModalOpen = true"
                                    class="mt-3 px-3.5 py-1.5 bg-slate-900 text-white rounded-lg text-xs font-semibold"
                                >
                                    Generate First Invoice
                                </button>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($bills->hasPages())
            <div class="px-4 py-3 border-t border-slate-100">
                {{ $bills->links() }}
            </div>
        @endif
    </div>

    <!-- ============================================================== -->
    <!-- MODAL 1: CREATE NEW BILL & INVOICE -->
    <!-- ============================================================== -->
    <div 
        x-show="createModalOpen" 
        x-cloak 
        class="fixed inset-0 z-50 flex items-center justify-center p-4 overflow-y-auto bg-slate-900/50 backdrop-blur-sm"
    >
        <div 
            @click.outside="createModalOpen = false"
            class="bg-white rounded-2xl shadow-xl border border-slate-200 w-full max-w-2xl overflow-hidden my-8"
        >
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-lg bg-red-100 text-red-600 flex items-center justify-center text-sm">
                        <i class="fa-solid fa-file-circle-plus"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-slate-900">Generate Student Bill &amp; Money Receipt</h3>
                        <p class="text-[11px] text-slate-500">Create official fee invoice for enrolled / counseling students</p>
                    </div>
                </div>
                <button @click="createModalOpen = false" class="text-slate-400 hover:text-slate-600">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <form action="{{ route('admin.billings.store') }}" method="POST" class="p-6 space-y-4">
                @csrf

                <!-- Select Existing Student Lead (Optional Auto-Fill) -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">
                        Select Existing Student (Optional Auto-Fill)
                    </label>
                    <select 
                        x-model="newBill.student_id" 
                        @change="onStudentSelect(newBill.student_id)"
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:bg-white focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500"
                    >
                        <option value="">-- Direct / Walk-in Student (Enter Details Below) --</option>
                        <template x-for="st in studentsList" :key="st.id">
                            <option :value="st.id" x-text="st.name + ' (' + st.phone + ') - ' + (st.course_interested || 'General')"></option>
                        </template>
                    </select>
                </div>

                <!-- Student Details Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Student Full Name <span class="text-red-500">*</span></label>
                        <input type="text" name="student_name" x-model="newBill.student_name" required placeholder="e.g. Rahul Kumar" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:bg-white focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Mobile / Phone Number <span class="text-red-500">*</span></label>
                        <input type="text" name="student_phone" x-model="newBill.student_phone" required placeholder="10-digit phone" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:bg-white focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Father's Name</label>
                        <input type="text" name="student_father_name" x-model="newBill.student_father_name" placeholder="Father's name" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:bg-white focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Course / Stream</label>
                        <input type="text" name="course_name" x-model="newBill.course_name" placeholder="e.g. B.Tech (CSE), BCA, Polytechnic" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:bg-white focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500">
                    </div>
                </div>

                <!-- Billing Purpose / Title -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Billing Purpose / Item Title <span class="text-red-500">*</span></label>
                    <input type="text" name="title" x-model="newBill.title" required placeholder="e.g. Admission Counselling & Registration Fee" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:bg-white focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500">
                </div>

                <!-- Financial Calculation Grid -->
                <div class="bg-slate-50/70 p-4 rounded-xl border border-slate-200 space-y-3">
                    <div class="text-[11px] font-bold uppercase tracking-wider text-slate-500">Fee Breakdown &amp; Calculation</div>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                        <div>
                            <label class="block text-[11px] font-bold text-slate-700 mb-1">Base Fee (₹) <span class="text-red-500">*</span></label>
                            <input type="number" step="0.01" min="0" name="amount" x-model="newBill.amount" required class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs font-bold focus:outline-none focus:ring-2 focus:ring-red-500">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-700 mb-1">Discount (₹)</label>
                            <input type="number" step="0.01" min="0" name="discount" x-model="newBill.discount" class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-red-500">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-700 mb-1">Tax / GST (₹)</label>
                            <input type="number" step="0.01" min="0" name="tax_amount" x-model="newBill.tax_amount" class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-red-500">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-emerald-700 mb-1">Paid Now (₹)</label>
                            <input type="number" step="0.01" min="0" name="paid_amount" x-model="newBill.paid_amount" class="w-full px-3 py-2 bg-white border border-emerald-300 rounded-xl text-xs font-bold text-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                        </div>
                    </div>

                    <!-- Computed Summary Strip -->
                    <div class="flex items-center justify-between pt-2 border-t border-slate-200 text-xs font-bold">
                        <div>
                            <span class="text-slate-500">Total Net Payable:</span>
                            <span class="text-slate-900 text-sm ml-1">₹<span x-text="calcTotal(newBill.amount, newBill.discount, newBill.tax_amount).toFixed(2)"></span></span>
                        </div>
                        <div>
                            <span class="text-slate-500">Remaining Due:</span>
                            <span class="text-amber-700 text-sm ml-1">₹<span x-text="calcDue(newBill.amount, newBill.discount, newBill.tax_amount, newBill.paid_amount).toFixed(2)"></span></span>
                        </div>
                    </div>
                </div>

                <!-- Payment Method & Details -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Payment Method</label>
                        <select name="payment_method" x-model="newBill.payment_method" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:bg-white focus:outline-none focus:ring-2 focus:ring-red-500">
                            <option value="Cash">Cash</option>
                            <option value="UPI / QR Code">UPI / QR Code (GooglePay/PhonePe/Paytm)</option>
                            <option value="Net Banking">Net Banking / IMPS / NEFT</option>
                            <option value="Debit / Credit Card">Debit / Credit Card</option>
                            <option value="DRCC Bihar Credit Card">DRCC Bihar Student Credit Card</option>
                            <option value="Cheque">Cheque</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Transaction Ref / UTR / Cheque No.</label>
                        <input type="text" name="transaction_id" x-model="newBill.transaction_id" placeholder="Optional reference" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:bg-white focus:outline-none focus:ring-2 focus:ring-red-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Billing Date <span class="text-red-500">*</span></label>
                        <input type="date" name="billing_date" x-model="newBill.billing_date" required class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:bg-white focus:outline-none focus:ring-2 focus:ring-red-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Due Date</label>
                        <input type="date" name="due_date" x-model="newBill.due_date" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:bg-white focus:outline-none focus:ring-2 focus:ring-red-500">
                    </div>
                </div>

                <!-- Notes / Remarks -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Notes / Terms</label>
                    <textarea name="notes" x-model="newBill.notes" rows="2" placeholder="Optional invoice notes or payment remarks..." class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:bg-white focus:outline-none focus:ring-2 focus:ring-red-500"></textarea>
                </div>

                <!-- Modal Actions -->
                <div class="flex items-center justify-end gap-2.5 pt-3 border-t border-slate-100">
                    <button type="button" @click="createModalOpen = false" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-semibold transition">
                        Cancel
                    </button>
                    <button type="submit" class="px-5 py-2 bg-gradient-to-r from-red-600 via-orange-600 to-amber-600 hover:from-red-700 hover:to-orange-700 text-white rounded-xl text-xs font-bold shadow-md shadow-red-500/20 transition">
                        Generate &amp; Save Bill
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ============================================================== -->
    <!-- MODAL 2: EDIT BILL & INVOICE -->
    <!-- ============================================================== -->
    <div 
        x-show="editModalOpen" 
        x-cloak 
        class="fixed inset-0 z-50 flex items-center justify-center p-4 overflow-y-auto bg-slate-900/50 backdrop-blur-sm"
    >
        <div 
            @click.outside="editModalOpen = false"
            class="bg-white rounded-2xl shadow-xl border border-slate-200 w-full max-w-2xl overflow-hidden my-8"
        >
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-lg bg-orange-100 text-orange-600 flex items-center justify-center text-sm">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-slate-900">Edit Invoice #<span x-text="currentBill.invoice_no"></span></h3>
                        <p class="text-[11px] text-slate-500">Update billing details, payment status and records</p>
                    </div>
                </div>
                <button @click="editModalOpen = false" class="text-slate-400 hover:text-slate-600">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <form :action="'{{ url('admin/billings') }}/' + currentBill.id" method="POST" class="p-6 space-y-4">
                @csrf
                @method('PUT')

                <!-- Student Details Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Student Full Name <span class="text-red-500">*</span></label>
                        <input type="text" name="student_name" x-model="currentBill.student_name" required class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:bg-white focus:outline-none focus:ring-2 focus:ring-red-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Mobile / Phone Number <span class="text-red-500">*</span></label>
                        <input type="text" name="student_phone" x-model="currentBill.student_phone" required class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:bg-white focus:outline-none focus:ring-2 focus:ring-red-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Father's Name</label>
                        <input type="text" name="student_father_name" x-model="currentBill.student_father_name" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:bg-white focus:outline-none focus:ring-2 focus:ring-red-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Course / Stream</label>
                        <input type="text" name="course_name" x-model="currentBill.course_name" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:bg-white focus:outline-none focus:ring-2 focus:ring-red-500">
                    </div>
                </div>

                <!-- Billing Purpose / Title -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Billing Purpose / Item Title <span class="text-red-500">*</span></label>
                    <input type="text" name="title" x-model="currentBill.title" required class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:bg-white focus:outline-none focus:ring-2 focus:ring-red-500">
                </div>

                <!-- Financial Calculation Grid -->
                <div class="bg-slate-50/70 p-4 rounded-xl border border-slate-200 space-y-3">
                    <div class="text-[11px] font-bold uppercase tracking-wider text-slate-500">Fee Breakdown &amp; Calculation</div>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                        <div>
                            <label class="block text-[11px] font-bold text-slate-700 mb-1">Base Fee (₹) <span class="text-red-500">*</span></label>
                            <input type="number" step="0.01" min="0" name="amount" x-model="currentBill.amount" required class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs font-bold focus:outline-none focus:ring-2 focus:ring-red-500">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-700 mb-1">Discount (₹)</label>
                            <input type="number" step="0.01" min="0" name="discount" x-model="currentBill.discount" class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-red-500">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-700 mb-1">Tax / GST (₹)</label>
                            <input type="number" step="0.01" min="0" name="tax_amount" x-model="currentBill.tax_amount" class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-red-500">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-emerald-700 mb-1">Paid Amount (₹)</label>
                            <input type="number" step="0.01" min="0" name="paid_amount" x-model="currentBill.paid_amount" class="w-full px-3 py-2 bg-white border border-emerald-300 rounded-xl text-xs font-bold text-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                        </div>
                    </div>

                    <!-- Computed Summary Strip -->
                    <div class="flex items-center justify-between pt-2 border-t border-slate-200 text-xs font-bold">
                        <div>
                            <span class="text-slate-500">Total Net Payable:</span>
                            <span class="text-slate-900 text-sm ml-1">₹<span x-text="calcTotal(currentBill.amount, currentBill.discount, currentBill.tax_amount).toFixed(2)"></span></span>
                        </div>
                        <div>
                            <span class="text-slate-500">Remaining Due:</span>
                            <span class="text-amber-700 text-sm ml-1">₹<span x-text="calcDue(currentBill.amount, currentBill.discount, currentBill.tax_amount, currentBill.paid_amount).toFixed(2)"></span></span>
                        </div>
                    </div>
                </div>

                <!-- Payment Method & Details -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3.5">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Payment Method</label>
                        <select name="payment_method" x-model="currentBill.payment_method" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:bg-white focus:outline-none focus:ring-2 focus:ring-red-500">
                            <option value="Cash">Cash</option>
                            <option value="UPI / QR Code">UPI / QR Code</option>
                            <option value="Net Banking">Net Banking</option>
                            <option value="Debit / Credit Card">Card</option>
                            <option value="DRCC Bihar Credit Card">DRCC Bihar Credit Card</option>
                            <option value="Cheque">Cheque</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Transaction Ref / UTR</label>
                        <input type="text" name="transaction_id" x-model="currentBill.transaction_id" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:bg-white focus:outline-none focus:ring-2 focus:ring-red-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Payment Status</label>
                        <select name="payment_status" x-model="currentBill.payment_status" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:bg-white focus:outline-none focus:ring-2 focus:ring-red-500">
                            <option value="paid">Paid</option>
                            <option value="partially_paid">Partially Paid</option>
                            <option value="unpaid">Unpaid</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Billing Date <span class="text-red-500">*</span></label>
                        <input type="date" name="billing_date" x-model="currentBill.billing_date" required class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:bg-white focus:outline-none focus:ring-2 focus:ring-red-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Due Date</label>
                        <input type="date" name="due_date" x-model="currentBill.due_date" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:bg-white focus:outline-none focus:ring-2 focus:ring-red-500">
                    </div>
                </div>

                <!-- Notes -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Notes</label>
                    <textarea name="notes" x-model="currentBill.notes" rows="2" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:bg-white focus:outline-none focus:ring-2 focus:ring-red-500"></textarea>
                </div>

                <!-- Modal Actions -->
                <div class="flex items-center justify-end gap-2.5 pt-3 border-t border-slate-100">
                    <button type="button" @click="editModalOpen = false" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-semibold transition">
                        Cancel
                    </button>
                    <button type="submit" class="px-5 py-2 bg-slate-900 hover:bg-slate-800 text-white rounded-xl text-xs font-bold transition">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ============================================================== -->
    <!-- MODAL 3: QUICK RECORD PAYMENT -->
    <!-- ============================================================== -->
    <div 
        x-show="payModalOpen" 
        x-cloak 
        class="fixed inset-0 z-50 flex items-center justify-center p-4 overflow-y-auto bg-slate-900/50 backdrop-blur-sm"
    >
        <div 
            @click.outside="payModalOpen = false"
            class="bg-white rounded-2xl shadow-xl border border-slate-200 w-full max-w-md overflow-hidden my-8"
        >
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-emerald-50/50">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center text-sm">
                        <i class="fa-solid fa-hand-holding-dollar"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-slate-900">Record Fee Payment</h3>
                        <p class="text-[11px] text-slate-500">Invoice: <span class="font-bold text-slate-700" x-text="activePayBill.invoice_no"></span></p>
                    </div>
                </div>
                <button @click="payModalOpen = false" class="text-slate-400 hover:text-slate-600">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <form :action="'{{ url('admin/billings') }}/' + activePayBill.id + '/record-payment'" method="POST" class="p-6 space-y-4">
                @csrf

                <!-- Bill Balance Banner -->
                <div class="bg-slate-50 p-3.5 rounded-xl border border-slate-200 flex items-center justify-between text-xs">
                    <div>
                        <div class="text-[11px] text-slate-500">Student:</div>
                        <div class="font-bold text-slate-900" x-text="activePayBill.student_name"></div>
                    </div>
                    <div class="text-right">
                        <div class="text-[11px] text-amber-600 font-bold">Outstanding Due:</div>
                        <div class="font-black text-amber-700 text-base">₹<span x-text="activePayBill.due_amount.toFixed(2)"></span></div>
                    </div>
                </div>

                <!-- Payment Amount -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Payment Amount (₹) <span class="text-red-500">*</span></label>
                    <input 
                        type="number" 
                        step="0.01" 
                        min="1" 
                        :max="activePayBill.due_amount" 
                        name="payment_amount" 
                        x-model="activePayBill.payment_amount" 
                        required 
                        class="w-full px-3 py-2 bg-white border border-emerald-300 rounded-xl text-sm font-bold text-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500"
                    >
                </div>

                <!-- Payment Mode -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Payment Method <span class="text-red-500">*</span></label>
                    <select name="payment_method" x-model="activePayBill.payment_method" required class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500">
                        <option value="UPI / QR Code">UPI / QR Code</option>
                        <option value="Cash">Cash</option>
                        <option value="Net Banking">Net Banking</option>
                        <option value="Debit / Credit Card">Debit / Credit Card</option>
                        <option value="DRCC Bihar Credit Card">DRCC Bihar Credit Card</option>
                        <option value="Cheque">Cheque</option>
                    </select>
                </div>

                <!-- Transaction Reference -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Transaction Ref / UTR / Cheque No.</label>
                    <input type="text" name="transaction_id" x-model="activePayBill.transaction_id" placeholder="e.g. UPI Ref: 38472910..." class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500">
                </div>

                <!-- Payment Date -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Payment Received Date</label>
                    <input type="date" name="payment_date" x-model="activePayBill.payment_date" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500">
                </div>

                <!-- Payment Remarks -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Payment Note</label>
                    <input type="text" name="notes" x-model="activePayBill.notes" placeholder="e.g. 1st installment paid at Patna office..." class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500">
                </div>

                <!-- Modal Actions -->
                <div class="flex items-center justify-end gap-2.5 pt-3 border-t border-slate-100">
                    <button type="button" @click="payModalOpen = false" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-semibold transition">
                        Cancel
                    </button>
                    <button type="submit" class="px-5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold shadow-md shadow-emerald-500/20 transition">
                        Record Payment
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ============================================================== -->
    <!-- MODAL 4: DELETE CONFIRMATION -->
    <!-- ============================================================== -->
    <div 
        x-show="deleteModalOpen" 
        x-cloak 
        class="fixed inset-0 z-50 flex items-center justify-center p-4 overflow-y-auto bg-slate-900/50 backdrop-blur-sm"
    >
        <div 
            @click.outside="deleteModalOpen = false"
            class="bg-white rounded-2xl shadow-xl border border-slate-200 w-full max-w-md overflow-hidden p-6 text-center space-y-4"
        >
            <div class="w-12 h-12 rounded-full bg-rose-100 text-rose-600 flex items-center justify-center mx-auto text-xl">
                <i class="fa-solid fa-triangle-exclamation"></i>
            </div>
            <div>
                <h3 class="text-base font-bold text-slate-900">Delete Invoice?</h3>
                <p class="text-xs text-slate-500 mt-1">
                    Are you sure you want to delete Invoice <strong class="text-slate-900" x-text="billToDelete.invoice_no"></strong> for <strong class="text-slate-900" x-text="billToDelete.student_name"></strong>? This record will be safely archived.
                </p>
            </div>
            <div class="flex items-center justify-center gap-3 pt-2">
                <button type="button" @click="deleteModalOpen = false" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-semibold transition">
                    Cancel
                </button>
                <form :action="'{{ url('admin/billings') }}/' + billToDelete.id" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-5 py-2 bg-rose-600 hover:bg-rose-700 text-white rounded-xl text-xs font-bold shadow-md shadow-rose-500/20 transition">
                        Confirm Delete
                    </button>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection
