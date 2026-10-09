import { react } from '../mascot';
import { completeRequirement } from './requirement';

const GENERATED_LENGTH = 20;
const GENERATOR_ALPHABET = 'abcdefghijkmnopqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ23456789!@#$%^&*-_+=?';

/** The vault's saved logins: the address each one belongs to, and its username. */
const SAVED_LOGINS = { 'mavibank.com.tr': 'ayse.yilmaz' };

/**
 * A random password from the browser's cryptographic generator, the way real vaults make them.
 */
function generatePassword() {
    const randomValues = crypto.getRandomValues(new Uint32Array(GENERATED_LENGTH));

    return Array.from(randomValues, (value) => GENERATOR_ALPHABET[value % GENERATOR_ALPHABET.length]).join('');
}

/**
 * The password vault: unlock it with the master password, reveal saved logins and
 * generate a new password. The autofill demo below only works once it is open.
 */
export function initVault() {
    const vault = document.querySelector('[data-vault]');

    if (!vault) {
        return;
    }

    const lock = vault.querySelector('[data-vault-lock]');
    const master = vault.querySelector('[data-vault-master]');
    const error = vault.querySelector('[data-vault-error]');
    const open = vault.querySelector('[data-vault-open]');
    const generated = vault.querySelector('[data-vault-generated]');
    let hasGenerated = false;

    lock.addEventListener('submit', (event) => {
        event.preventDefault();

        if (master.value !== vault.dataset.master) {
            error.textContent = 'Ana parola hatalı. Kasa, ana parola olmadan açılamaz; kasayı yapan şirket bile açamaz.';
            react('wrong');

            return;
        }

        lock.hidden = true;
        open.hidden = false;
        vault.setAttribute('data-unlocked', '');
        open.querySelector('[data-vault-title]').focus();
        react('correct');
    });

    vault.querySelectorAll('[data-vault-entry]').forEach((entry) => {
        const secret = entry.querySelector('[data-vault-secret]');
        const toggle = entry.querySelector('[data-vault-reveal]');

        toggle.addEventListener('click', () => {
            const isHidden = toggle.textContent.trim() === 'Göster';

            secret.textContent = isHidden ? secret.dataset.vaultSecret : '••••••••••••';
            toggle.textContent = isHidden ? 'Gizle' : 'Göster';
        });
    });

    vault.querySelector('[data-vault-generate]').addEventListener('click', () => {
        const password = generatePassword();
        const bits = Math.round(GENERATED_LENGTH * Math.log2(GENERATOR_ALPHABET.length));

        generated.hidden = false;
        vault.querySelector('[data-vault-generated-value]').textContent = password;
        vault.querySelector('[data-vault-generated-note]').textContent = `${GENERATED_LENGTH} rastgele karakter, yaklaşık ${bits} bit. Saniyede 10 milyar tahminle bile kırılması evrenin yaşından çok daha uzun sürer. Ezberlemene gerek yok; kasan hatırlar.`;

        if (!hasGenerated) {
            hasGenerated = true;
            completeRequirement(vault);
        }
    });

    initAutofill(vault);
}

/**
 * Two login pages that look the same; the vault fills only the one whose address it knows.
 */
function initAutofill(vault) {
    const demo = document.querySelector('[data-autofill]');

    if (!demo) {
        return;
    }

    const tried = new Set();
    const sites = [...demo.querySelectorAll('[data-autofill-site]')];
    const lesson = document.querySelector('[data-autofill-lesson]');

    sites.forEach((site) => {
        const domain = site.dataset.autofillSite;
        const result = site.querySelector('[data-autofill-result]');

        site.querySelector('[data-autofill-button]').addEventListener('click', () => {
            if (!vault.hasAttribute('data-unlocked')) {
                result.dataset.tone = 'wrong';
                result.textContent = 'Kasa kilitli. Önce yukarıdaki kasayı ana parolanla aç.';

                return;
            }

            const username = SAVED_LOGINS[domain];

            if (username) {
                site.querySelector('[data-autofill-username]').value = username;
                site.querySelector('[data-autofill-password]').value = 'q7#Vt2m!Lx9@Rk4pW1zN';
                result.dataset.tone = 'correct';
                result.textContent = `Kasa bu adresi tanıdı (${domain}) ve giriş bilgilerini doldurdu.`;
                react('correct');
            } else {
                result.dataset.tone = 'wrong';
                result.textContent = `Kasada ${domain} için kayıtlı bir giriş yok. Dikkat: bu, Mavi Bank’ın adresi değil!`;
                lesson.hidden = false;
                react('wrong');
            }

            tried.add(domain);

            if (tried.size === sites.length) {
                completeRequirement(demo);
            }
        });
    });
}
