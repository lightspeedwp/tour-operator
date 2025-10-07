---
name: "Default PR"
about: "General change; use for features, improvements, refactors when no specific template fits"
title: "change: <short summary>"
---
<!-- Note: YAML front matter is for context/Copilot; GitHub does not parse it for PR metadata. -->

## Summary
<!-- Why are we changing this? What is the user impact/outcome? -->
**Linked issues**: Closes #<id> (and/or) Relates to #<id>

## Changes
- <bullet list of notable changes>

## Screenshots / Before–After (if UI)
<add images or remove section>

## Test Notes
- [ ] Steps to verify (browsers/devices):
- [ ] Edge cases covered:

## Risk & Rollback
- Risk level: Low / Medium / High
- Rollback plan: <how to revert / flags / migrations>

---
### Checklist (Global DoD / PR)
- [ ] All AC met and demonstrated
- [ ] Tests added/updated (unit/E2E as appropriate)
- [ ] A11y considerations addressed where relevant
- [ ] Docs/readme/changelog updated (if user-facing)
- [ ] Security/perf impact reviewed where relevant
- [ ] Code/design reviews approved
- [ ] CI green; linked issues closed; release notes prepared (if shipping)
