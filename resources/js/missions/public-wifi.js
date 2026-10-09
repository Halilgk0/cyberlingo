import { react } from '../mascot';
import { completeRequirement } from './requirement';

const PORTAL_HOST = 'okulportal.example';

function randomHex(byteCount) {
    return [...crypto.getRandomValues(new Uint8Array(byteCount))].map((byte) => byte.toString(16).padStart(2, '0')).join(' ');
}

/** What the eavesdropper captures when Ayşe logs in, as [tone, text] lines. */
function capturedTraffic(mode, username, password) {
    const time = new Date().toLocaleTimeString('tr-TR');

    if (mode === 'http') {
        return [
            ['muted', `[${time}] ayse-telefon → ${PORTAL_HOST}`],
            ['', `GET http://${PORTAL_HOST}/giris`],
            ['', 'POST /giris'],
            ['danger', `kullanici=${username}&parola=${password}`],
            ['danger', '⚠ Parola açık metin olarak yakalandı!'],
        ];
    }

    return [
        ['muted', `[${time}] ayse-telefon → ${PORTAL_HOST} (şifreli bağlantı)`],
        ['', `şifreli veri: ${randomHex(12)}`],
        ['', `şifreli veri: ${randomHex(12)}`],
        ['safe', '✓ İçerik okunamıyor. Sadece bağlanılan site görünüyor.'],
    ];
}

const EXPLANATIONS = {
    http: 'http ile gönderilen her şey açık metin olarak gider. Aynı ağdaki saldırgan Ayşe’nin kullanıcı adını ve parolasını olduğu gibi okudu.',
    https: `https ile bilgiler telefondan çıkmadan şifrelendi. Saldırgan Ayşe’nin ${PORTAL_HOST} sitesine bağlandığını görüyor ama ne gönderdiğini göremiyor.`,
};

/**
 * Ayşe logs in over http or https while the eavesdropper's console shows what leaks.
 */
function initEavesdrop() {
    const demo = document.querySelector('[data-eavesdrop]');

    if (!demo) {
        return;
    }

    const modeButtons = [...demo.querySelectorAll('[data-eavesdrop-mode]')];
    const badge = demo.querySelector('[data-eavesdrop-badge]');
    const url = demo.querySelector('[data-eavesdrop-url]');
    const form = demo.querySelector('[data-eavesdrop-form]');
    const log = demo.querySelector('[data-eavesdrop-log]');
    const explanation = demo.querySelector('[data-eavesdrop-explanation]');
    const triedModes = new Set();

    let mode = 'http';

    modeButtons.forEach((button) => {
        button.addEventListener('click', () => {
            mode = button.dataset.eavesdropMode;
            modeButtons.forEach((each) => each.setAttribute('aria-checked', String(each === button)));
            badge.textContent = mode === 'https' ? 'Şifreli' : 'Güvenli değil';
            badge.toggleAttribute('data-secure', mode === 'https');
            url.textContent = `${mode}://${PORTAL_HOST}/giris`;
        });
    });

    form.addEventListener('submit', (event) => {
        event.preventDefault();

        const [username, password] = [...form.querySelectorAll('input')].map((input) => input.value);

        log.replaceChildren(
            ...capturedTraffic(mode, username, password).map(([tone, text]) => {
                const line = document.createElement('li');

                line.textContent = text;

                if (tone) {
                    line.dataset.tone = tone;
                }

                return line;
            }),
        );

        explanation.textContent = EXPLANATIONS[mode];
        triedModes.add(mode);
        demo.querySelector(`[data-eavesdrop-tried="${mode}"]`).setAttribute('data-done', '');

        if (triedModes.size === modeButtons.length) {
            completeRequirement(demo);
        }
    });
}

/**
 * The phone's Wi-Fi list: every network explains itself when tapped, the real one completes the step.
 */
function initWifiPicker() {
    const picker = document.querySelector('[data-wifi-picker]');

    if (!picker) {
        return;
    }

    const networks = [...picker.querySelectorAll('[data-network]')];
    const feedback = picker.querySelector('[data-wifi-feedback]');
    const feedbackTitle = picker.querySelector('[data-wifi-feedback-title]');
    const feedbackBody = picker.querySelector('[data-wifi-feedback-body]');

    networks.forEach((network) => {
        const button = network.querySelector('button');

        button.addEventListener('click', () => {
            if (button.getAttribute('aria-disabled') === 'true') {
                return;
            }

            const isReal = network.dataset.network === 'real';

            button.dataset.state = isReal ? 'correct' : 'wrong';
            button.setAttribute('aria-disabled', 'true');
            feedback.dataset.tone = isReal ? 'correct' : 'wrong';
            feedbackTitle.textContent = isReal ? 'Doğru ağ, bağlandın!' : 'Bu ağa bağlanma, başka birini dene.';
            feedbackBody.replaceChildren(network.querySelector('[data-network-feedback]').content.cloneNode(true));
            feedback.hidden = false;
            react(isReal ? 'correct' : 'wrong');

            if (isReal) {
                networks.forEach((each) => each.querySelector('button').setAttribute('aria-disabled', 'true'));
                completeRequirement(picker);
            }
        });
    });
}

export function initPublicWifi() {
    initEavesdrop();
    initWifiPicker();
}
