import { react } from '../mascot';
import { completeRequirement } from './requirement';

/**
 * A branching incident simulation. The scenario (scenes, choices, status chips and the
 * ending rules) arrives as JSON in the page. Each choice locks in, applies its
 * consequences to the status chips, shows its feedback and leads to the next scene.
 * Reaching any ending completes the mission; the learner can replay to try another path.
 */
export function initIncidents() {
    document.querySelectorAll('[data-incident]').forEach((incident) => {
        const scenario = JSON.parse(incident.querySelector('[data-incident-data]').textContent);
        const timeLabel = incident.querySelector('[data-incident-time]');
        const sceneBox = incident.querySelector('[data-incident-scene]');
        const choicesBox = incident.querySelector('[data-incident-choices]');
        const choiceTemplate = incident.querySelector('[data-incident-choice]');
        const outcome = incident.querySelector('[data-incident-outcome]');

        incident.querySelector('[data-incident-nojs]')?.remove();

        let flags;
        let score;
        let log;

        const setChip = (key, chip) => {
            const element = incident.querySelector(`[data-status-chip="${key}"]`);

            if (element && chip) {
                element.dataset.tone = chip.tone;
                element.querySelector('[data-status-value]').textContent = chip.value;
            }
        };

        const renderScene = (sceneId) => {
            const scene = scenario.scenes[sceneId];

            timeLabel.textContent = scene.time ?? timeLabel.textContent;

            sceneBox.replaceChildren();
            if (scene.speaker) {
                const speaker = document.createElement('p');
                speaker.className = 'text-rune text-sm font-bold';
                speaker.textContent = scene.speaker;
                sceneBox.append(speaker);
            }
            const text = document.createElement('p');
            text.className = 'mt-1 leading-relaxed focus:outline-none sm:text-lg';
            text.tabIndex = -1;
            text.textContent = scene.text;
            sceneBox.append(text);
            text.focus({ preventScroll: true });

            choicesBox.replaceChildren();
            scene.choices.forEach((choice) => {
                const node = choiceTemplate.content.firstElementChild.cloneNode(true);
                const button = node.querySelector('button');

                button.textContent = choice.label;
                button.addEventListener('click', () => pick(scene, choice, node, button));
                choicesBox.append(node);
            });
        };

        const pick = (scene, choice, node, button) => {
            choicesBox.querySelectorAll('button').forEach((each) => each.setAttribute('aria-disabled', 'true'));
            button.dataset.picked = '';

            Object.entries(choice.status ?? {}).forEach(([key, chip]) => setChip(key, chip));
            (choice.flags ?? []).forEach((flag) => flags.add(flag));
            score += choice.score ?? 0;
            log.push({ tone: choice.tone, text: choice.feedback });

            react(choice.tone === 'good' ? 'correct' : choice.tone === 'bad' ? 'wrong' : 'correct');

            const feedback = node.querySelector('[data-choice-feedback]');
            feedback.dataset.tone = choice.tone;
            feedback.textContent = choice.feedback;
            feedback.hidden = false;

            const next = document.createElement('button');
            next.type = 'button';
            next.className = 'btn-primary mt-4';
            next.textContent = choice.to === scenario.resolve.at ? 'Olayı kapat' : 'Devam et';
            next.addEventListener('click', () => {
                if (choice.to === scenario.resolve.at) {
                    finish();
                } else {
                    renderScene(choice.to);
                }
            });
            feedback.after(next);
            next.focus({ preventScroll: true });
        };

        const finish = () => {
            const { failFlag, good, ok, fail, goodScore } = scenario.resolve;
            const endingId = flags.has(failFlag) ? fail : score >= goodScore ? good : ok;
            const ending = scenario.scenes[endingId];

            timeLabel.textContent = ending.time ?? timeLabel.textContent;
            sceneBox.hidden = true;
            choicesBox.hidden = true;

            incident.querySelector('[data-outcome-badge]').textContent = ending.badge;
            incident.querySelector('[data-outcome-badge]').classList.add(
                ending.ending === 'success' ? 'text-safe' : ending.ending === 'fail' ? 'text-alert' : 'text-signal',
            );
            incident.querySelector('[data-outcome-title]').textContent = ending.title;
            incident.querySelector('[data-outcome-text]').textContent = ending.text;

            incident.querySelector('[data-outcome-log]').replaceChildren(...log.map((entry) => {
                const item = document.createElement('li');
                item.className = 'flex gap-2 leading-snug';
                const mark = document.createElement('span');
                mark.setAttribute('aria-hidden', 'true');
                mark.textContent = entry.tone === 'good' ? '✓' : entry.tone === 'bad' ? '✕' : '•';
                mark.className = entry.tone === 'good' ? 'text-safe font-bold' : entry.tone === 'bad' ? 'text-alert font-bold' : 'text-signal font-bold';
                const span = document.createElement('span');
                span.className = 'text-muted';
                span.textContent = entry.text;
                item.append(mark, span);

                return item;
            }));

            outcome.hidden = false;
            outcome.focus({ preventScroll: true });
            react(ending.ending === 'fail' ? 'wrong' : 'correct');
            completeRequirement(incident);
        };

        incident.querySelector('[data-incident-replay]').addEventListener('click', () => {
            outcome.hidden = true;
            sceneBox.hidden = false;
            choicesBox.hidden = false;
            start();
            sceneBox.scrollIntoView({ behavior: 'smooth', block: 'center' });
        });

        const start = () => {
            flags = new Set();
            score = 0;
            log = [];
            Object.entries(scenario.status).forEach(([key, chip]) => setChip(key, chip));
            renderScene(scenario.start);
        };

        start();
    });
}
