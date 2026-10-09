import { react } from '../mascot';
import { completeRequirement } from './requirement';
import { toggleSwitch } from './switch';

/**
 * The permission screen: one app at a time, the learner switches on what it needs,
 * saves, and sees a verdict for each permission until every switch is right.
 */
export function initPermissions() {
    const demo = document.querySelector('[data-permissions]');

    if (!demo) {
        return;
    }

    const apps = [...demo.querySelectorAll('[data-permissions-app]')];
    const progress = demo.querySelector('[data-permissions-progress]');
    const position = demo.querySelector('[data-permissions-position]');
    const done = demo.querySelector('[data-permissions-done]');
    const feedback = demo.querySelector('[data-permissions-feedback]');
    const feedbackTitle = demo.querySelector('[data-permissions-feedback-title]');
    const feedbackIntro = demo.querySelector('[data-permissions-feedback-intro]');
    const results = demo.querySelector('[data-permissions-results]');
    const resultTemplate = demo.querySelector('[data-permissions-result]');
    const nextButton = demo.querySelector('[data-permissions-next]');

    let currentIndex = 0;

    demo.querySelector('[data-permissions-total]').textContent = apps.length;

    const showApp = (index) => {
        currentIndex = index;
        apps.forEach((app, appIndex) => {
            app.hidden = appIndex !== index;
        });
        position.textContent = index + 1;
        nextButton.hidden = true;
    };

    const describe = (item, toggle, isRight) => {
        const result = resultTemplate.content.firstElementChild.cloneNode(true);
        const isOn = toggle.getAttribute('aria-checked') === 'true';
        const name = toggle.textContent.replace(/\s+/g, ' ').trim();

        result.dataset.tone = isRight ? 'correct' : 'wrong';
        result.querySelector('[data-permissions-result-title]').textContent = `${isRight ? '✓' : '✗'} ${name}: ${isOn ? 'izin verdin' : 'reddettin'}`;
        result.querySelector('[data-permissions-result-reason]').replaceChildren(item.querySelector('[data-permission-reason]').content.cloneNode(true));

        return result;
    };

    apps.forEach((app) => {
        const items = [...app.querySelectorAll('[data-permission]')];
        const appName = app.querySelector('[data-permissions-app-name]').textContent.trim();

        items.forEach((item) => {
            const toggle = item.querySelector('[data-permission-toggle]');

            toggle.addEventListener('click', () => {
                if (app.hasAttribute('data-passed')) {
                    return;
                }

                toggleSwitch(toggle);
                delete item.dataset.result;
            });
        });

        app.querySelector('[data-permissions-save]').addEventListener('click', () => {
            if (app.hasAttribute('data-passed')) {
                return;
            }

            const verdicts = items.map((item) => {
                const toggle = item.querySelector('[data-permission-toggle]');
                const isRight = (toggle.getAttribute('aria-checked') === 'true') === (item.dataset.permission === 'needed');

                item.dataset.result = isRight ? 'correct' : 'wrong';

                return describe(item, toggle, isRight);
            });
            const wrongCount = verdicts.filter((verdict) => verdict.dataset.tone === 'wrong').length;

            results.replaceChildren(...verdicts);
            feedbackIntro.hidden = true;
            feedback.dataset.tone = wrongCount === 0 ? 'correct' : 'wrong';
            react(wrongCount === 0 ? 'correct' : 'wrong');

            if (wrongCount > 0) {
                feedbackTitle.textContent = `${wrongCount} izin yanlış ayarlandı. Kırmızı olanları düzeltip tekrar kaydet.`;

                return;
            }

            feedbackTitle.textContent = `${appName} için doğru ayarlar!`;
            app.setAttribute('data-passed', '');
            items.forEach((item) => item.querySelector('[data-permission-toggle]').setAttribute('aria-disabled', 'true'));
            nextButton.textContent = currentIndex === apps.length - 1 ? 'Bitir' : 'Sonraki uygulama';
            nextButton.hidden = false;
            nextButton.focus();
        });
    });

    nextButton.addEventListener('click', () => {
        results.replaceChildren();
        delete feedback.dataset.tone;

        if (currentIndex === apps.length - 1) {
            apps[currentIndex].hidden = true;
            progress.hidden = true;
            nextButton.hidden = true;
            feedbackTitle.textContent = 'Dört uygulamanın izinlerini de doğru ayarladın.';
            done.hidden = false;
            done.focus();
            completeRequirement(demo);

            return;
        }

        showApp(currentIndex + 1);
        feedbackTitle.textContent = 'Yeni bir uygulama. Yine aynı soruyu sor: buna gerçekten ihtiyacı var mı?';
        apps[currentIndex].querySelector('[data-permissions-app-name]').focus();
    });

    showApp(0);
}
