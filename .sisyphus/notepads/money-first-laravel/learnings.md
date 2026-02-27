# Learnings: Money-First Laravel Invoice App

## Task 5: Dashboard and Customer Management CRUD

### Livewire 4 Functional Components
- Livewire 4 uses functional components stored in `resources/views/components/⚡{name}.blade.php`
- Lightning bolt emoji (⚡) prefix indicates Livewire Volt functional component
- Component structure: PHP class at top, Blade template below
- Use `with()` method to pass data to view (replaces render() in class-based components)

### Routing Livewire Components
- Cannot use `Livewire\Volt\Volt::route()` without Volt package installed
- Alternative: Use standard Laravel routes with closures returning `view('components.⚡name')`
- Route model binding works: `function (Customer $customer) { return view('...', ['customer' => $customer]); }`
- Example:
  ```php
  Route::get('customers/{customer}', function (\App\Models\Customer $customer) {
      return view('components.customers.⚡show', ['customer' => $customer]);
  })->name('customers.show');
  ```

### Component Data Handling
- Use `#[Validate]` attributes for form validation in Livewire 4
- `with()` method returns array of data available in template
- Access relationships with eager loading: `Invoice::with('customer')->latest()->get()`
- Use `withCount()` for relationship counts: `Customer::withCount('invoices', 'quotations')`

### Empty State Handling Best Practices
- Always handle empty collections: `@if($collection->isEmpty())`
- Provide helpful empty state messages
- Include call-to-action for first-time users
- Handle null values: `sum()` returns null, use `?? 0` for coalescing
- Avoid division by zero: Check count before calculating percentages
- Empty states prevent "No results" looking like broken page

### SGD Currency Formatting
- Pattern: `$ {number_format($amount, 2, '.', ',')}`
- Example output: `$ 1,234.56`
- Always use 2 decimal places for financial data
- Comma thousands separator, period decimal separator

### Livewire Reactive Features
- `wire:model.live.debounce.300ms` for live search with debouncing
- `wire:submit` for form submission without page reload
- `wire:confirm` for confirmation dialogs (new in Livewire 3+)
- `wire:click` for button actions
- `#[Url]` attribute to sync property with URL query string

### Tailwind CSS Patterns Used
- Responsive grids: `grid gap-4 md:grid-cols-2`
- Card design: `rounded-xl border border-neutral-200 bg-white dark:bg-neutral-800 p-6`
- Dark mode: All colors have `dark:` variants
- Status badges: Conditional classes based on status (green=paid, blue=sent, gray=draft)
- Table styling: `divide-y divide-neutral-200` for row separators

### Component Architecture
- Separate components for different concerns: Index, Form, Show
- Reuse Form component for both Create and Edit (check for `$customer` existence)
- Mount hook for initializing component: `public function mount(?Customer $customer = null)`
- Flash messages: `session()->flash('success', 'Message')` then `$this->redirect()`

### Testing & Evidence
- Empty state testing crucial for production readiness
- Test with cleared database: `Model::truncate()`
- Evidence files show functionality without visual screenshots
- Document expected behavior vs actual results

### Common Pitfalls Avoided
- Livewire components need Livewire runtime, can't render standalone
- Route order matters: specific routes before wildcard routes
- Model binding must use full namespace in route closure
- Empty collections are falsy in Blade (`@if($items->isEmpty())` not `@if(!$items)`)

### Performance Considerations
- Debounce search to reduce server requests (300ms is good default)
- Eager load relationships to avoid N+1 queries
- Use `withCount()` instead of loading full relationships for counts
- Limit recent items (5 is reasonable for dashboard)

### Next Steps
- Invoice and Quotation CRUD will follow similar patterns
- PDF generation for invoices will require DOMPDF/Snappy
- Email sending will use Laravel Mail with Mailtrap for testing
