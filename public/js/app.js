document.addEventListener('DOMContentLoaded', function () {

    /*
    |--------------------------------------------------------------------------
    | DARK MODE
    |--------------------------------------------------------------------------
    */

    const themeToggle =
        document.getElementById('themeToggle');


    function darkModeEnabled() {

        return document.documentElement
            .classList
            .contains('dark');

    }


    function updateThemeButton() {

        if (!themeToggle) {
            return;
        }

        if (darkModeEnabled()) {

            themeToggle.innerHTML = '☀️';

            themeToggle.setAttribute(
                'aria-label',
                'Ativar modo claro'
            );

        } else {

            themeToggle.innerHTML = '🌙';

            themeToggle.setAttribute(
                'aria-label',
                'Ativar modo escuro'
            );

        }

    }


    if (themeToggle) {

        themeToggle.addEventListener(
            'click',
            function () {

                document.documentElement
                    .classList
                    .toggle('dark');

                const theme =
                    darkModeEnabled()
                        ? 'dark'
                        : 'light';

                localStorage.setItem(
                    'helpdesk-theme',
                    theme
                );

                updateThemeButton();

            }
        );

    }


    updateThemeButton();


    /*
    |--------------------------------------------------------------------------
    | MENU MOBILE
    |--------------------------------------------------------------------------
    */

    const menuButton =
        document.getElementById('menuButton');

    const mainNav =
        document.getElementById('mainNav');


    if (menuButton && mainNav) {

        menuButton.addEventListener(
            'click',
            function () {

                mainNav.classList.toggle('open');

                menuButton.innerHTML =
                    mainNav.classList.contains('open')
                        ? '✕'
                        : '☰';

            }
        );

    }


    /*
    |--------------------------------------------------------------------------
    | CONTADOR DA DESCRIÇÃO
    |--------------------------------------------------------------------------
    */

    const description =
        document.getElementById('description');

    const characterCount =
        document.getElementById('characterCount');


    function updateCharacterCounter() {

        if (
            !description ||
            !characterCount
        ) {
            return;
        }

        characterCount.innerText =
            description.value.length +
            ' caracteres';

    }


    if (description) {

        description.addEventListener(
            'input',
            updateCharacterCounter
        );

        updateCharacterCounter();

    }
        /*
|--------------------------------------------------------------------------
| CONTADOR DA RESPOSTA DO CHAMADO
|--------------------------------------------------------------------------
*/

const messageInput = document.getElementById('message');
const messageCharacterCount = document.getElementById('messageCharacterCount');

function updateMessageCounter() {
    if (!messageInput || !messageCharacterCount) {
        return;
    }

    messageCharacterCount.innerText =
        messageInput.value.length + ' caracteres';
}

if (messageInput) {
    messageInput.addEventListener('input', updateMessageCounter);
    updateMessageCounter();
}
});