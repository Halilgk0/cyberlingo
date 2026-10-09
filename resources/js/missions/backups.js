import { react } from '../mascot';
import { completeRequirement } from './requirement';

/** Pause between two files being locked or restored, so the learner can watch it happen. */
const FILE_STEP_MILLISECONDS = 350;

const wait = (milliseconds) => new Promise((resolve) => setTimeout(resolve, milliseconds));

const CHOICE_TITLES = {
    pay: 'Ödeme yaptın… ama anahtar hiç gelmedi.',
    restart: 'Dosyalar hâlâ şifreli.',
    restore: 'Dosyaların geri geldi!',
};

/**
 * The ransomware simulation: opening the attachment locks the files one by one,
 * then the learner picks a way out until they restore from the backup.
 */
function initRansomware() {
    const demo = document.querySelector('[data-ransomware]');

    if (!demo) {
        return;
    }

    const files = [...demo.querySelectorAll('[data-file]')];
    const note = demo.querySelector('[data-ransom-note]');
    const email = demo.querySelector('[data-ransom-email]');
    const choices = demo.querySelector('[data-ransom-choices]');
    const choiceButtons = [...demo.querySelectorAll('[data-ransom-choice]')];
    const feedback = demo.querySelector('[data-ransom-feedback]');
    const feedbackTitle = demo.querySelector('[data-ransom-feedback-title]');
    const feedbackBody = demo.querySelector('[data-ransom-feedback-body]');

    const setLocked = (file, isLocked) => {
        file.toggleAttribute('data-locked', isLocked);
        file.querySelector('[data-file-icon-display]').textContent = isLocked ? '🔒' : file.dataset.fileIcon;
        file.querySelector('[data-file-label]').textContent = isLocked ? `${file.dataset.fileName}.kilitli` : file.dataset.fileName;
    };

    demo.querySelector('[data-ransom-open]').addEventListener('click', async () => {
        email.hidden = true;

        for (const file of files) {
            setLocked(file, true);
            await wait(FILE_STEP_MILLISECONDS);
        }

        note.hidden = false;
        choices.hidden = false;
        demo.querySelector('[data-ransom-choices-heading]').focus();
    });

    choiceButtons.forEach((button) => {
        button.addEventListener('click', async () => {
            if (button.getAttribute('aria-disabled') === 'true') {
                return;
            }

            const choice = button.dataset.ransomChoice;
            const isRight = button.dataset.ransomChoiceRight === 'yes';

            button.dataset.state = isRight ? 'correct' : 'wrong';
            button.setAttribute('aria-disabled', 'true');
            feedback.dataset.tone = isRight ? 'correct' : 'wrong';
            feedbackTitle.textContent = CHOICE_TITLES[choice];
            feedbackBody.replaceChildren(demo.querySelector(`[data-ransom-outcome="${choice}"]`).content.cloneNode(true));
            feedback.hidden = false;
            react(isRight ? 'correct' : 'wrong');

            if (!isRight) {
                return;
            }

            choiceButtons.forEach((each) => each.setAttribute('aria-disabled', 'true'));
            note.hidden = true;

            for (const file of files) {
                setLocked(file, false);
                await wait(FILE_STEP_MILLISECONDS);
            }

            completeRequirement(demo);
        });
    });
}

/**
 * The backup planner: every ticked copy is tested against four disasters and the 3-2-1 rule.
 */
function initBackupPlanner() {
    const planner = document.querySelector('[data-backup-planner]');

    if (!planner) {
        return;
    }

    const options = [...planner.querySelectorAll('[data-backup-option]')];
    const disasters = [...planner.querySelectorAll('[data-disaster]')];
    const rules = Object.fromEntries([...planner.querySelectorAll('[data-backup-rule]')].map((rule) => [rule.dataset.backupRule, rule]));
    const status = planner.querySelector('[data-backup-status]');

    const setRule = (name, isMet, detail) => {
        rules[name].toggleAttribute('data-met', isMet);
        rules[name].querySelector('[data-backup-rule-detail]').textContent = detail;
    };

    const render = () => {
        const chosen = options.filter((option) => option.checked);
        const copyCount = chosen.length + 1;
        const mediumCount = new Set(['computer', ...chosen.map((option) => option.dataset.medium)]).size;
        const hasOffsiteCopy = chosen.some((option) => option.dataset.offsite === 'yes');

        const survivorsOf = (disasterName) => chosen.filter((option) => option.dataset.survives.split(' ').includes(disasterName));

        const survivesEverything = disasters
            .map((disaster) => {
                const survivors = survivorsOf(disaster.dataset.disaster);

                disaster.toggleAttribute('data-survived', survivors.length > 0);
                disaster.querySelector('[data-disaster-detail]').textContent = survivors.length > 0
                    ? `Kurtaran: ${survivors.map((option) => option.dataset.shortName).join(', ')}`
                    : 'Bütün kopyaların gider.';

                return survivors.length > 0;
            })
            .every(Boolean);

        setRule('copies', copyCount >= 3, `Şu an ${copyCount} kopya`);
        setRule('media', mediumCount >= 2, `Şu an ${mediumCount} farklı ortam`);
        setRule('offsite', hasOffsiteCopy, hasOffsiteCopy ? 'Var' : 'Henüz yok');

        const followsRule = copyCount >= 3 && mediumCount >= 2 && hasOffsiteCopy;

        if (survivesEverything && followsRule) {
            status.dataset.tone = 'correct';
            status.textContent = 'Planın hazır! Her felakette en az bir kopya ayakta kalıyor ve 3-2-1 kuralına uyuyorsun. Gerçek hayatta da aynısını kur.';

            if (survivorsOf('ransomware').length === 1) {
                status.textContent += ' İpucu: fidye yazılımına karşı tek bir kopyan dayanıyor. Harici diski yedekten sonra çıkarırsan ikinci bir güvencen olur.';
            }

            completeRequirement(planner);
        } else if (survivesEverything) {
            delete status.dataset.tone;
            status.textContent = 'Bütün felaketlere dayanıyor ama 3-2-1 kuralını tamamla: tek bir yedeğe güvenme, o da bozulabilir ya da hesabına erişemeyebilirsin.';
        } else {
            delete status.dataset.tone;
            status.textContent = '';
        }
    };

    options.forEach((option) => option.addEventListener('change', render));
    render();
}

export function initBackups() {
    initRansomware();
    initBackupPlanner();
}
