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

    // Sets the open max-height in rem from the answer's full content height.
    function setAnswerHeight(answer) {
        const rootFontSize =
            parseFloat(
                window.getComputedStyle(document.documentElement).fontSize
            ) || 16;

        answer.style.setProperty(
            '--lsx-to-faq-answer-height',
            `${answer.scrollHeight / rootFontSize}rem`
        );
    }

    function toggleSection(section, question, answer) {
        const isOpen = section.classList.toggle('is-open');

        if (isOpen) {
            setAnswerHeight(answer);
        }

        // Collapsed answers are hidden from focus and assistive technology.
        answer.inert = !isOpen;
        question.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
    }

    // Text reflows on resize, so re-measure answers that are open.
    function refreshOpenAnswers() {
        document
            .querySelectorAll(
                '.schema-faq.is-accordion .schema-faq-section.is-open > .schema-faq-answer'
            )
            .forEach(setAnswerHeight);
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

        answer.inert = !isInitiallyOpen;
        if (isInitiallyOpen) {
            setAnswerHeight(answer);
        }

        question.addEventListener('click', () =>
            toggleSection(section, question, answer)
        );
        question.addEventListener('keydown', (event) => {
            if ('Enter' === event.key || ' ' === event.key) {
                event.preventDefault();
                toggleSection(section, question, answer);
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

        let resizeFrame = 0;
        window.addEventListener('resize', () => {
            window.cancelAnimationFrame(resizeFrame);
            resizeFrame = window.requestAnimationFrame(refreshOpenAnswers);
        });
    }

    if ('loading' === document.readyState) {
        document.addEventListener('DOMContentLoaded', initFaqAccordions);
    } else {
        initFaqAccordions();
    }
})();
