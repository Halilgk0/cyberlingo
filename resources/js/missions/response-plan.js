import { react } from '../mascot';
import { completeRequirement } from './requirement';

/**
 * A crisis plan built by tapping steps in order. Steps that share a stage may come
 * in any order; a step picked too early gets a hint under it, and a trap is crossed
 * out with its explanation. Both count as a slip in the summary.
 */
export function initResponsePlans() {
    document.querySelectorAll('[data-response-plan]').forEach((plan) => {
        const steps = [...plan.querySelectorAll('[data-plan-step]')];
        const planSteps = steps.filter((step) => !step.hasAttribute('data-trap'));
        const list = plan.querySelector('[data-plan-list]');
        const count = plan.querySelector('[data-plan-count]');
        const prompt = plan.querySelector('[data-plan-prompt]');
        const itemTemplate = plan.querySelector('[data-plan-item]');
        let slips = 0;
        let lastHint = null;

        plan.querySelector('[data-plan-total]').textContent = planSteps.length;

        const whyOf = (step) => step.querySelector('[data-plan-step-why]').content.cloneNode(true);

        const remaining = () => planSteps.filter((step) => !step.hasAttribute('data-placed'));

        const nextStage = () => Math.min(...remaining().map((step) => Number(step.dataset.stage)));

        const showFeedback = (step, title, body) => {
            const feedback = step.querySelector('[data-plan-step-feedback]');
            const heading = document.createElement('p');

            heading.className = 'font-bold';
            heading.textContent = title;
            feedback.replaceChildren(heading, body);
            feedback.hidden = false;

            return feedback;
        };

        const place = (step) => {
            const item = itemTemplate.content.firstElementChild.cloneNode(true);

            item.querySelector('[data-plan-item-number]').textContent = list.children.length + 1;
            item.querySelector('[data-plan-item-label]').textContent = step.querySelector('button').textContent.trim();
            item.querySelector('[data-plan-item-why]').append(whyOf(step));
            list.append(item);

            step.setAttribute('data-placed', '');
            step.hidden = true;
            count.textContent = list.children.length;
            plan.querySelector('[data-plan-empty]').hidden = true;
        };

        const finish = () => {
            const summary = plan.querySelector('[data-plan-summary]');

            plan.querySelector('[data-plan-choices]').hidden = true;
            summary.hidden = false;
            plan.querySelector('[data-plan-summary-score]').textContent = slips === 0
                ? 'Kusursuz plan! Hiç tökezlemeden doğru sırayı kurdun.'
                : `Planın hazır. Yolda ${slips} kez tökezledin; gerçek bir krizde bu sırayı hatırlamak çok şey kurtarır.`;
            summary.focus();
            completeRequirement(plan);
        };

        steps.forEach((step) => {
            const button = step.querySelector('button');

            button.addEventListener('click', () => {
                if (button.getAttribute('aria-disabled') === 'true') {
                    return;
                }

                if (lastHint) {
                    lastHint.hidden = true;
                    lastHint = null;
                }

                if (step.hasAttribute('data-trap')) {
                    slips++;
                    button.dataset.state = 'wrong';
                    button.setAttribute('aria-disabled', 'true');
                    showFeedback(step, 'Bu bir tuzak, plana girmez.', whyOf(step));
                    react('wrong');

                    return;
                }

                if (Number(step.dataset.stage) !== nextStage()) {
                    slips++;
                    button.dataset.state = 'wrong';
                    setTimeout(() => delete button.dataset.state, 600);
                    lastHint = showFeedback(
                        step,
                        'Bunun da sırası gelecek, ama önce daha acil bir adım var.',
                        document.createTextNode('Kendine sor: şu anda en çok neyi kaybetmek üzereyim?'),
                    );
                    react('wrong');

                    return;
                }

                place(step);
                react('correct');
                plan.querySelector('[data-plan-announcer]').textContent = `Doğru adım. Planın ${list.children.length}. adımı oldu.`;

                if (remaining().length === 0) {
                    finish();

                    return;
                }

                prompt.focus({ preventScroll: true });
            });
        });
    });
}
