---
description: 'Comprehensive accessibility guidelines for Tour Operator plugin development ensuring WCAG 2.2 AA compliance'
applyTo: '**/*'
---

# Accessibility Instructions (WCAG 2.2 AA)

## Objectives
Ensure Block Editor patterns and blocks meet **WCAG 2.2 AA** standards and deliver inclusive UX in both editor and front end.

## Core Requirements

### Semantic HTML & Structure
- Use **semantic HTML**: proper headings (h1-h6), lists, landmarks, buttons
- Avoid `div`-itis - use appropriate semantic elements
- Maintain proper **heading hierarchy** - no skipped levels for visual styling alone
- Use landmark blocks (Header, Footer, Navigation, Main) appropriately

### Keyboard Navigation
- Ensure **keyboard access** for all interactive elements
- Tab/Shift+Tab order must be logical and follow source order
- Add **visible focus styles** for all focusable elements
- Esc key should close dialogs and modals
- Keyboard navigability: focus order should match source order

### ARIA Implementation
- Use **ARIA** only when needed - don't override native semantics
- Provide meaningful `aria-label` and `aria-describedby` attributes
- Use `aria-live` regions for dynamic content updates (polite announcements)
- Form errors should use `aria-live` and programmatic focus management

### Visual Design & Color
- **Color contrast** must meet AA standards (4.5:1 for normal text, 3:1 for large text)
- Use theme color presets to ensure contrast compliance
- Respect `prefers-reduced-motion` for animations
- Don't rely solely on color to convey information

### Images & Media
- Provide **meaningful alt text** for all informative images
- Use `alt=""` or `aria-hidden="true"` for decorative images
- Include alt text placeholders in block patterns with editor guidance
- Provide captions/transcripts for video content as required

### Links & Interactive Elements
- **Link text** must be meaningful and descriptive
- Avoid generic text like "click here", "read more", "learn more"
- Label buttons and form controls clearly
- Ensure interactive elements have sufficient touch targets (44x44px minimum)

### Forms & Input
- Labels must be properly linked to inputs
- Error messages should use `aria-live` regions
- Provide clear instructions and validation feedback
- Use appropriate input types and autocomplete attributes

### Editor Experience
- Provide meaningful block titles, descriptions, and keywords in `block.json`
- Include editor-specific accessibility guidance in block descriptions
- Ensure block controls are keyboard accessible

### Internationalization & RTL
- Test with RTL languages
- Never concatenate translatable strings
- Ensure proper text direction support

## Testing Requirements

### Automated Testing
- **axe-core**: Zero serious/critical violations allowed
- Run accessibility audits in CI/CD pipeline
- Include accessibility tests in Playwright test suite

### Manual Testing
- **Keyboard navigation**: Test all functionality with keyboard only
- **Screen reader testing**: Smoke test with NVDA/VoiceOver/JAWS
- **Playwright**: Verify keyboard paths and focus order
- Test with high contrast mode and zoom up to 200%

### Browser Testing
- Test across different browsers and assistive technologies
- Verify compatibility with common screen readers
- Test mobile accessibility on touch devices

## Implementation Guidelines

### Block Development
- Use `useBlockProps()` for proper wrapper attributes
- Include accessibility considerations in block registration
- Provide clear block descriptions and usage instructions

### Pattern Development
- Include accessibility notes in pattern descriptions
- Provide guidance on proper heading levels and alt text
- Test patterns in various contexts and layouts

### Documentation
- Document accessibility features and considerations
- Provide examples of proper implementation
- Include accessibility testing instructions

## Resources
- [WCAG 2.2 Guidelines](https://www.w3.org/WAI/WCAG22/quickref/)
- [WordPress Accessibility Handbook](https://make.wordpress.org/accessibility/handbook/)
- [axe-core Testing](https://github.com/dequelabs/axe-core)
- [Accessible Rich Internet Applications (ARIA)](https://www.w3.org/WAI/ARIA/apg/)
