import { react } from '../mascot';
import { completeRequirement } from './requirement';

/** Pause between incoming messages of the same turn, so they arrive one after another. */
const MESSAGE_DELAY_SECONDS = 0.6;

/**
 * Practice conversations. Each turn's messages arrive in the thread, then the learner
 * picks a reply: a risky reply is crossed out and explained, the safe one is sent
 * and the conversation moves on.
 */
export function initChats() {
    document.querySelectorAll('[data-chat]').forEach((chat) => {
        const log = chat.querySelector('[data-chat-log]');
        const turns = [...chat.querySelectorAll('[data-chat-turn]')];
        const coach = chat.querySelector('[data-chat-coach]');
        const coachTitle = chat.querySelector('[data-chat-coach-title]');
        const coachBody = chat.querySelector('[data-chat-coach-body]');
        const continueButton = chat.querySelector('[data-chat-continue]');
        const outcome = chat.querySelector('[data-chat-outcome]');
        const sentBubble = chat.querySelector('[data-chat-sent]').content.firstElementChild;

        let currentIndex = 0;

        const showCoach = (tone, title, feedback) => {
            coach.dataset.tone = tone;
            coachTitle.textContent = title;
            coachBody.replaceChildren(feedback.content.cloneNode(true));
            coach.hidden = false;
        };

        const finish = () => {
            outcome.hidden = false;
            outcome.focus();
            completeRequirement(chat);
        };

        const startTurn = (index) => {
            const turn = turns[index];
            const messages = [...turn.querySelector('[data-chat-turn-messages]').content.cloneNode(true).children];

            currentIndex = index;
            messages.forEach((message, messageIndex) => {
                message.style.animationDelay = `${messageIndex * MESSAGE_DELAY_SECONDS}s`;
            });
            log.append(...messages);

            if (!turn.querySelector('[data-chat-reply]')) {
                finish();

                return;
            }

            turn.hidden = false;
        };

        turns.forEach((turn, turnIndex) => {
            turn.querySelectorAll('[data-chat-reply]').forEach((reply) => {
                const button = reply.querySelector('button');
                const feedback = reply.querySelector('[data-chat-reply-feedback]');

                button.addEventListener('click', () => {
                    if (button.getAttribute('aria-disabled') === 'true') {
                        return;
                    }

                    if (reply.dataset.chatReply !== 'safe') {
                        button.dataset.state = 'wrong';
                        button.setAttribute('aria-disabled', 'true');
                        showCoach('wrong', 'Riskli bir yanıt. Başka bir şey dene.', feedback);
                        react('wrong');

                        return;
                    }

                    const sent = sentBubble.cloneNode(true);
                    sent.textContent = button.textContent.replace(/\s+/g, ' ').trim();
                    log.append(sent);

                    turn.hidden = true;
                    showCoach('correct', 'Güvenli bir yanıt!', feedback);
                    react('correct');

                    if (turnIndex === turns.length - 1) {
                        finish();

                        return;
                    }

                    continueButton.hidden = false;
                    continueButton.focus();
                });
            });
        });

        continueButton.addEventListener('click', () => {
            continueButton.hidden = true;
            coach.hidden = true;
            startTurn(currentIndex + 1);
            turns[currentIndex].querySelector('[data-chat-turn-prompt]')?.focus();
        });

        startTurn(0);
    });
}
