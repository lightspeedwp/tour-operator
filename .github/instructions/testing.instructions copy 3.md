# Instruction — Testing Patterns

**Manual**
- Insert pattern in editor; verify preview matches intent.
- Toggle light/dark (style variations) and responsive widths.
- Keyboard-only navigation test.
- Swap copy lengths (short/long) to check resilience.
- For Woo: verify allowed inner blocks and checkout/cart flows.

**Automation (optional)**
- Use Playwright + `@wordpress/e2e-test-utils-playwright`
- Tests: insertion, presence of key blocks, no console errors.
