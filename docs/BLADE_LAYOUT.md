# Blade Layout System - CodeCraft Frontend

This document explains the Blade layout structure for the CodeCraft Laravel application.

## Directory Structure

```
resources/views/
├── layouts/
│   └── app.blade.php          # Main layout file
├── partials/
│   ├── header.blade.php       # Header with navigation
│   ├── footer.blade.php       # Footer with links
│   ├── styles.blade.php       # CSS styles
│   └── scripts.blade.php      # JavaScript functionality
└── home.blade.php             # Homepage content
```

## Layout Components

### 1. Main Layout (`layouts/app.blade.php`)

The main layout file that wraps all pages. It includes:
- Document structure (HTML, head, body)
- Meta tags and title section
- Styles inclusion
- Header partial
- Content section (yield)
- Footer partial
- Scripts inclusion

**Usage:**
```blade
@extends('layouts.app')

@section('title', 'Your Page Title')

@section('content')
    <!-- Your page content here -->
@endsection
```

### 2. Header Partial (`partials/header.blade.php`)

Contains:
- Logo and branding
- Desktop navigation menu
- Mobile menu toggle
- Theme toggle button
- CTA button

**Features:**
- Sticky header
- Active link highlighting
- Responsive mobile menu
- Dark/light theme toggle

### 3. Footer Partial (`partials/footer.blade.php`)

Contains:
- Company information
- Service links
- Product links
- Contact information
- Social media links
- Copyright notice

### 4. Styles Partial (`partials/styles.blade.php`)

Complete CSS styling including:
- CSS custom properties (variables) for theming
- Light and dark mode support
- Responsive design (mobile, tablet, desktop)
- Component styles (buttons, cards, modals)
- Utility classes

**CSS Variables:**
```css
--bg-primary: Background color
--text-primary: Text color
--primary-color: Brand color
--border-color: Border color
--card-shadow: Shadow effects
```

### 5. Scripts Partial (`partials/scripts.blade.php`)

JavaScript functionality:
- Theme toggle (dark/light mode)
- Mobile menu toggle
- Smooth scrolling
- Product filtering
- Product modal
- Local storage for theme preference

## Creating New Pages

To create a new page using the layout:

1. **Create a new Blade file** in `resources/views/`:
```blade
@extends('layouts.app')

@section('title', 'Page Title')

@section('content')
    <section class="section">
        <div class="container">
            <h1>Your Content</h1>
        </div>
    </section>
@endsection
```

2. **Add a route** in `routes/web.php`:
```php
Route::get('/your-page', function () {
    return view('your-page');
});
```

## Adding Custom Styles

To add page-specific styles:

```blade
@extends('layouts.app')

@push('styles')
<style>
    .custom-class {
        /* Your custom styles */
    }
</style>
@endpush

@section('content')
    <!-- Your content -->
@endsection
```

## Adding Custom Scripts

To add page-specific JavaScript:

```blade
@extends('layouts.app')

@section('content')
    <!-- Your content -->
@endsection

@push('scripts')
<script>
    // Your custom JavaScript
    console.log('Page loaded');
</script>
@endpush
```

## Available CSS Classes

### Layout Classes
- `.container` - Centered container with max-width
- `.section` - Standard section padding
- `.section-title` - Large centered title
- `.section-subtitle` - Subtitle text

### Button Classes
- `.btn` - Base button
- `.btn-primary` - Primary button (brand color)
- `.btn-outline` - Outlined button
- `.btn-secondary` - Secondary button
- `.btn-white` - White button
- `.btn-transparent` - Transparent button
- `.btn-small` - Small button
- `.btn-large` - Large button

### Card Classes
- `.service-card` - Service card with hover effect
- `.product-card` - Product card
- `.experience-card` - About/experience card

### Utility Classes
- `.text-center` - Center text
- `.mb-1, .mb-2, .mb-3, .mb-4` - Margin bottom
- `.mt-1, .mt-2, .mt-3, .mt-4` - Margin top
- `.flex` - Flexbox display
- `.flex-col` - Flex column
- `.items-center` - Align items center
- `.justify-between` - Justify space between
- `.gap-1, .gap-2, .gap-3` - Gap spacing
- `.hidden` - Hide element

### Badge Classes
- `.badge` - Small badge/tag
- `.tech-badge` - Technology badge
- `.product-badge` - Product featured badge

## Theme Support

The layout supports both light and dark themes:

**Light Mode (Default):**
- White backgrounds
- Dark text
- Subtle shadows

**Dark Mode:**
- Dark backgrounds
- Light text
- Enhanced shadows

Theme preference is saved in localStorage and persists across sessions.

## Responsive Breakpoints

- **Desktop:** > 992px
- **Tablet:** 768px - 992px
- **Mobile:** < 768px
- **Small Mobile:** < 480px

## Navigation Links

Update navigation links in `partials/header.blade.php`:

```blade
<a href="{{ url('/page') }}" class="{{ Request::is('page') ? 'active' : '' }}">
    Page Name
</a>
```

## Best Practices

1. **Always extend the layout:**
   ```blade
   @extends('layouts.app')
   ```

2. **Set page title:**
   ```blade
   @section('title', 'Descriptive Title')
   ```

3. **Use container for content:**
   ```blade
   <div class="container">
       <!-- Content -->
   </div>
   ```

4. **Use semantic HTML:**
   - `<section>` for major sections
   - `<article>` for independent content
   - `<header>`, `<footer>`, `<nav>` for structure

5. **Follow CSS variable naming:**
   - Use existing CSS variables for consistency
   - Add new variables to `:root` if needed

## Testing

To test the layout:

1. Start Laravel development server:
   ```bash
   php artisan serve
   ```

2. Visit: `http://localhost:8000`

3. Test features:
   - Theme toggle
   - Mobile menu
   - Responsive design
   - Navigation links
   - Product modals

## Customization

### Changing Brand Colors

Edit CSS variables in `partials/styles.blade.php`:

```css
:root {
    --primary-color: #6366f1;  /* Your brand color */
    --accent-color: #8b5cf6;   /* Accent color */
}
```

### Changing Fonts

Update font imports in `layouts/app.blade.php`:

```html
<link href="https://fonts.googleapis.com/css2?family=YourFont:wght@400;700&display=swap" rel="stylesheet">
```

Then update CSS:

```css
body {
    font-family: 'YourFont', sans-serif;
}
```

## Support

For issues or questions about the Blade layout system, refer to:
- [Laravel Blade Documentation](https://laravel.com/docs/blade)
- [Laravel Routing Documentation](https://laravel.com/docs/routing)
