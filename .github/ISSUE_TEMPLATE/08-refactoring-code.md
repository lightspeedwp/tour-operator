---
name: "Code Refactoring / Review"
about: "Request or propose a code refactoring or review task to improve code quality, maintainability, and consistency."
title: "[Refactor]: <describe the code area to refactor>"
labels: ["refactor", "code quality", "needs review"]
---

### Code Area(s) Impacted ###
- [ ] Tour management
- [ ] Booking system
- [ ] Frontend display
- [ ] Admin interface
- [ ] Integrations
- [x] Other: Code review and refactoring workflow

### Is your code refactoring request related to a problem? ###
Describe the current pain points or risks (e.g., technical debt, code smells, inconsistent patterns, lack of clarity or documentation):


### Describe the Refactoring / Review Task ###
Provide a clear outline of the refactoring or code review objectives. Consider including:
- Scope of the refactor (e.g., files, modules, components)
- Goals (e.g., improve readability, modularize logic, remove dead code)
- Guidance for using automated tools such as GitHub Copilot or code-review bots
- Areas to focus on (naming, structure, code style, documentation, etc.)
- Modularization, component separation, and performance considerations


### Use Case ###
Who will benefit from the refactor? How will it improve ongoing development, maintenance, or onboarding?


### Alternatives Considered ###
- Manual, unstructured code changes or reviews
- Relying solely on pull request templates (may not address pre-PR improvements)


### Additional Context ###
Include links, references, or rationale for the refactoring. Mention any best practices, standards, or tools to use (e.g., Copilot, linters, review bots):


### Example Code Snippets ###
```js
// Before:
function processBooking(data) {
  // ... long function ...
}
// After Copilot suggestion:
function validateBooking(data) { ... }
function calculateTotal(data) { ... }
function saveBooking(data) { ... }
```

### Refactoring / Review Checklist ###
- [ ] Code is modular, readable, and follows naming conventions
- [ ] Dead code, duplication, and code smells are addressed
- [ ] Comments and documentation are clear and up-to-date
- [ ] No regressions or breaking changes introduced
- [ ] Automated tools (Copilot, linters, review bots) have been run and feedback addressed
- [ ] Performance is not negatively impacted
- [ ] Code is peer-reviewed and follows project standards
- [ ] Tests are added or updated as needed
- [ ] Changelog is updated if applicable

### References ###
- [GitHub Copilot documentation](https://docs.github.com/en/copilot)
- [github.com/code-review](https://github.com/code-review)
- Internal code quality guidelines
