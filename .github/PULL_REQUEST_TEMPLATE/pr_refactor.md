---
name: "Refactor PR"
about: "Internal code improvement; no external behaviour change"
title: "refactor: <scope>"
---
<!-- Note: YAML front matter is for context/Copilot; GitHub does not parse it for PR metadata. -->

## Context
<!-- Internal improvement; no external behaviour change intended -->
- Scope: <modules/files>
- Motivation: <maintainability/perf/debt>

## Safety Nets
- Existing tests covering behaviour:
- New/refined tests added:
- Static analysis/lint rules touched:

## Approach
- Structural changes (APIs, patterns):
- Dead code removed? <Yes/No>

## Metrics / Benchmarks (if applicable)
- Before: <numbers>
- After: <numbers>

## Verification
- [ ] Unit tests pass locally
- [ ] Key flows smoke-tested (list)
- [ ] No user-visible diffs observed

## Risk & Rollback
- Risk level: Low / Medium / High
- Rollback plan: <revert commit / guarded behind no-ops>

---
### Checklist (Global DoD / PR)
- [ ] All AC met and demonstrated
- [ ] Tests added/updated (unit/E2E as appropriate)
- [ ] A11y considerations addressed where relevant
- [ ] Docs/readme/changelog updated (if user-facing)
- [ ] Security/perf impact reviewed where relevant
- [ ] Code/design reviews approved
- [ ] CI green; linked issues closed; release notes prepared (if shipping)
