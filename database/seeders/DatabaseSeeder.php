<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Quotation;
use App\Models\QuotationItem;
use App\Models\CompanySetting;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create default user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@sme-invoice.sg',
            'password' => bcrypt('password123'),
        ]);
        
        // Create Singapore customers
        $customers = [
            [
                'name' => 'David Tan',
                'email' => 'david@temasek-solutions.com.sg',
                'phone' => '+65 6221 3456',
                'company_name' => 'Temasek Solutions Pte Ltd',
                'address' => "10 Anson Road\n#15-10 International Plaza\nSingapore 079903",
            ],
            [
                'name' => 'Sarah Lim',
                'email' => 'sarah.lim@marinabaytech.sg',
                'phone' => '+65 6334 5678',
                'company_name' => 'Marina Bay Tech Pte Ltd',
                'address' => "3 Temasek Avenue\n#12-01 Centennial Tower\nSingapore 039190",
            ],
            [
                'name' => 'Kevin Wong',
                'email' => 'kevin@orcharddigital.com.sg',
                'phone' => '+65 6738 9012',
                'company_name' => 'Orchard Digital Solutions Pte Ltd',
                'address' => "238 Orchard Road\n#08-02 The Centrepoint\nSingapore 238854",
            ],
            [
                'name' => 'Michelle Koh',
                'email' => 'michelle@rafflesventures.sg',
                'phone' => '+65 6532 1098',
                'company_name' => 'Raffles Ventures Pte Ltd',
                'address' => "1 Raffles Place\n#20-05 One Raffles Place\nSingapore 048616",
            ],
            [
                'name' => 'James Chen',
                'email' => 'james@sentosasystems.com.sg',
                'phone' => '+65 6275 4321',
                'company_name' => 'Sentosa Systems Pte Ltd',
                'address' => "8 Marina Boulevard\n#05-02 Marina Bay Financial Centre\nSingapore 018981",
            ],
        ];
        
        foreach ($customers as $customerData) {
            Customer::create($customerData);
        }
        
        // Create sample invoices
        $customer1 = Customer::where('company_name', 'Temasek Solutions Pte Ltd')->first();
        $customer2 = Customer::where('company_name', 'Marina Bay Tech Pte Ltd')->first();
        $customer3 = Customer::where('company_name', 'Orchard Digital Solutions Pte Ltd')->first();
        
        // Invoice 1
        $invoice1 = Invoice::create([
            'customer_id' => $customer1->id,
            'invoice_number' => 'INV-2026-0001',
            'due_date' => now()->addDays(30),
            'status' => 'sent',
            'subtotal' => 5000.00,
            'gst_amount' => 450.00,
            'total' => 5450.00,
            'notes' => 'E-commerce website development project - Phase 1',
        ]);
        
        InvoiceItem::create([
            'invoice_id' => $invoice1->id,
            'description' => 'Web Development - Homepage & Product Pages',
            'quantity' => 40,
            'unit_price' => 100.00,
            'amount' => 4000.00,
        ]);
        
        InvoiceItem::create([
            'invoice_id' => $invoice1->id,
            'description' => 'Payment Gateway Integration',
            'quantity' => 1,
            'unit_price' => 1000.00,
            'amount' => 1000.00,
        ]);
        
        // Invoice 2
        $invoice2 = Invoice::create([
            'customer_id' => $customer2->id,
            'invoice_number' => 'INV-2026-0002',
            'due_date' => now()->addDays(15),
            'status' => 'paid',
            'subtotal' => 1200.00,
            'gst_amount' => 108.00,
            'total' => 1308.00,
            'notes' => 'Monthly maintenance and cloud hosting',
        ]);
        
        InvoiceItem::create([
            'invoice_id' => $invoice2->id,
            'description' => 'Monthly Maintenance',
            'quantity' => 1,
            'unit_price' => 800.00,
            'amount' => 800.00,
        ]);
        
        InvoiceItem::create([
            'invoice_id' => $invoice2->id,
            'description' => 'Cloud Hosting (AWS)',
            'quantity' => 1,
            'unit_price' => 400.00,
            'amount' => 400.00,
        ]);
        
        // Invoice 3
        $invoice3 = Invoice::create([
            'customer_id' => $customer3->id,
            'invoice_number' => 'INV-2026-0003',
            'due_date' => now()->addDays(45),
            'status' => 'draft',
            'subtotal' => 3200.00,
            'gst_amount' => 288.00,
            'total' => 3488.00,
            'notes' => 'Mobile app development consultation',
        ]);
        
        InvoiceItem::create([
            'invoice_id' => $invoice3->id,
            'description' => 'Mobile App Consultation & Planning',
            'quantity' => 16,
            'unit_price' => 150.00,
            'amount' => 2400.00,
        ]);
        
        InvoiceItem::create([
            'invoice_id' => $invoice3->id,
            'description' => 'UI/UX Design Mockups',
            'quantity' => 1,
            'unit_price' => 800.00,
            'amount' => 800.00,
        ]);
        
        // Create sample quotations
        $customer4 = Customer::where('company_name', 'Raffles Ventures Pte Ltd')->first();
        $customer5 = Customer::where('company_name', 'Sentosa Systems Pte Ltd')->first();
        
        // Quotation 1
        $quotation1 = Quotation::create([
            'customer_id' => $customer4->id,
            'quotation_number' => 'QUO-2026-0001',
            'valid_until' => now()->addDays(30),
            'status' => 'sent',
            'subtotal' => 8500.00,
            'gst_amount' => 765.00,
            'total' => 9265.00,
            'notes' => 'Complete website redesign with CMS integration',
        ]);
        
        QuotationItem::create([
            'quotation_id' => $quotation1->id,
            'description' => 'Website Redesign (10 pages)',
            'quantity' => 1,
            'unit_price' => 6000.00,
            'amount' => 6000.00,
        ]);
        
        QuotationItem::create([
            'quotation_id' => $quotation1->id,
            'description' => 'CMS Integration (WordPress)',
            'quantity' => 1,
            'unit_price' => 2500.00,
            'amount' => 2500.00,
        ]);
        
        // Quotation 2
        $quotation2 = Quotation::create([
            'customer_id' => $customer5->id,
            'quotation_number' => 'QUO-2026-0002',
            'valid_until' => now()->addDays(14),
            'status' => 'draft',
            'subtotal' => 2400.00,
            'gst_amount' => 216.00,
            'total' => 2616.00,
            'notes' => 'SEO optimization and analytics setup',
        ]);
        
        QuotationItem::create([
            'quotation_id' => $quotation2->id,
            'description' => 'SEO Audit & Optimization',
            'quantity' => 1,
            'unit_price' => 1500.00,
            'amount' => 1500.00,
        ]);
        
        QuotationItem::create([
            'quotation_id' => $quotation2->id,
            'description' => 'Google Analytics Setup & Training',
            'quantity' => 1,
            'unit_price' => 900.00,
            'amount' => 900.00,
        ]);
        
        // Create company settings
        CompanySetting::create([
            'company_name' => 'SME Invoice Solutions Pte Ltd',
            'gst_registration_number' => 'M90363827F',
            'address' => "123 Tech Park Drive\n#05-01 Innovation Centre\nSingapore 638131",
            'phone' => '+65 6123 4567',
            'email' => 'billing@sme-invoice.sg',
        ]);
        
        $this->command->info('✅ Database seeded successfully!');
        $this->command->info('   - 5 Customers created');
        $this->command->info('   - 3 Invoices created (1 draft, 1 sent, 1 paid)');
        $this->command->info('   - 2 Quotations created (1 draft, 1 sent)');
        $this->command->info('   - Company settings configured');
    }
}
