/**
 * FAQ Accordion
 *
 * Turns the Yoast FAQ block into an accessible accordion. Ported from ls-theme
 * (assets/js/faq-accordion.js). Sections already enhanced (role="button") are
 * skipped, so it is safe if the theme loads its own copy too.
 *
 * @package
 */

(function () {
    'use strict';

    function toggleSection(section, question) {
        const isOpen = section.classList.toggle('is-open');
        question.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
    }

    function enhanceSection(section, index) {
        const question = section.querySelector('.schema-faq-question');
        const answer = section.querySelector('.schema-faq-answer');

        if (!question || !answer) {
            return;
        }

        if ('button' === question.getAttribute('role')) {
            return;
        }

        const answerId = answer.id || `schema-faq-answer-${index}`;
        answer.id = answerId;

        const isInitiallyOpen = section.classList.contains('is-open');

        question.setAttribute('role', 'button');
        question.setAttribute('tabindex', '0');
        question.setAttribute(
            'aria-expanded',
            isInitiallyOpen ? 'true' : 'false'
        );
        question.setAttribute('aria-controls', answerId);

        question.addEventListener('click', () =>
            toggleSection(section, question)
        );
        question.addEventListener('keydown', (event) => {
            if ('Enter' === event.key || ' ' === event.key) {
                event.preventDefault();
                toggleSection(section, question);
            }
        });
    }

    function initFaqAccordions() {
        const sections = document.querySelectorAll('.schema-faq-section');

        if (0 === sections.length) {
            return;
        }

        document.querySelectorAll('.schema-faq').forEach((faq) => {
            faq.classList.add('is-accordion');
        });

        sections.forEach(enhanceSection);
    }

    if ('loading' === document.readyState) {
        document.addEventListener('DOMContentLoaded', initFaqAccordions);
    } else {
        initFaqAccordions();
    }
})();
