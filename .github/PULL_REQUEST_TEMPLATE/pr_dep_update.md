---
name: "Dependencies/Maintenance PR"
about: "Routine upkeep: dependency bumps, lint/format, low-risk hygiene"
title: "chore(deps): <packages>"
---
<!-- Note: YAML front matter is for context/Copilot; GitHub does not parse it for PR metadata. -->

## Maintenance summary
- Packages bumped: <list>
- Rationale: <security / compatibility / hygiene>

## Impact assessment
- Build/bundle deltas: <sizes/time>
- Risk notes: <breaking changes / peer deps>

## Test scope
- [ ] Install & build
- [ ] Smoke tests
- [ ] Key pages/components checked

---
### Checklist (Global DoD / PR)
- [ ] All AC met and demonstrated
- [ ] Tests added/updated (unit/E2E as appropriate)
- [ ] A11y considerations addressed where relevant
- [ ] Docs/readme/changelog updated (if user-facing)
- [ ] Security/perf impact reviewed where relevant
- [ ] Code/design reviews approved
- [ ] CI green; linked issues closed; release notes prepared (if shipping)
