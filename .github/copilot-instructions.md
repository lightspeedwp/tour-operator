# 🧠 GitHub Copilot Repository Instructions

These are repository-specific instructions to guide GitHub Copilot’s behavior when generating or editing code within this project. They apply to Copilot Chat, Copilot Coding Agent, and Copilot Code Review.

---

## 🔍 Project Overview

This repository is a WordPress plugin (Tour Operator) project. It is built using PHP, leverages WordPress blocks for custom functionality, and strictly follows the WordPress Coding Standards (WPCS). The codebase is structured as a WordPress plugin and may include PHP files, block registration, and other WordPress-specific patterns.

---

## 🛠️ Technologies and Tooling

- **Languages:** JavaScript (ES2022+), TypeScript
- **Runtime:** Node.js
- **Package Manager:** npm or yarn (based on `package.json`)
- **Linting:** ESLint with Prettier
- **Testing:** Vitest / Jest (unit tests), Playwright (E2E tests)
- **Frameworks:** None assumed unless otherwise declared in `/src`

---

## 🧩 Project Structure

```

.github/
src/
├── core/             # Business logic modules
├── api/              # API client utilities and request logic
├── components/       # UI components (React or framework-agnostic)
└── utils/            # Helper utilities
tests/
docs/

````

Avoid placing logic in `index.ts` files—prefer explicit imports.

---

## 💡 Coding Conventions

- Prefer functional, stateless patterns when applicable
- Use async/await; avoid `.then()` chains
- Use named exports; avoid default exports unless wrapping a module
- Keep logic modular—each file should have a single clear responsibility
- Avoid adding logic in `src/index.ts` or top-level entry files
- Document public functions with JSDoc

---

## 📦 Build & Run Commands

* **Development**
-  
  ```bash
  npm run dev
````

* **Lint and Format**

  ```bash
  npm run lint
  npm run format
  ```

* **Run Tests**

  ```bash
  npm test
  ```

* **Build**

  ```bash
  npm run build
  ```

---

## ⛔ Avoid These Patterns

* Do not include any WordPress-related imports, functions, or file structures
* Do not scaffold routes or components using Express, Next.js, or any framework unless explicitly declared
* Do not generate `.php`, `.twig`, or legacy CMS files
* Do not reference or assume plugins like WooCommerce or Wetu

---

## ✅ Agent-Specific Prompts

When asked to:

* "Generate an endpoint" → Place it in `src/api/`, include a test in `tests/`
* "Create a new module" → Follow folder structure and export pattern
* "Refactor" → Improve modularity, clarify naming, remove dead code
* "Write tests" → Use Vitest or Jest for unit tests, Playwright for E2E tests; place in `tests/`, mirror structure of `src/`

---

## 🔒 Content Exclusion (Optional but Recommended)

If supported by your GitHub plan, exclude these directories in settings:

```
/wordpress/
/deprecated/
/classic-theme/
```

---

## 📣 Feedback

We’re actively refining how we use GitHub Copilot. When in doubt, ask the team before suggesting code related to frameworks or languages not in use.
