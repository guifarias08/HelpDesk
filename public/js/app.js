document.addEventListener('DOMContentLoaded', function () {

    /*
    |--------------------------------------------------------------------------
    | DARK / LIGHT MODE
    |--------------------------------------------------------------------------
    */

    const themeToggle =
        document.getElementById('themeToggle');


    function isLightMode() {

        return document.documentElement
            .classList
            .contains('light');

    }


    function updateThemeIcon() {

        if (!themeToggle) {
            return;
        }

        themeToggle.textContent =
            isLightMode()
                ? '☾'
                : '☀';

    }


    if (themeToggle) {

        themeToggle.addEventListener(
            'click',
            function () {

                document.documentElement
                    .classList
                    .toggle('light');


                const theme =
                    isLightMode()
                        ? 'light'
                        : 'dark';


                localStorage.setItem(
                    'helpdesk-theme',
                    theme
                );


                updateThemeIcon();

            }
        );


        updateThemeIcon();

    }


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

                menuButton.textContent =
                    mainNav.classList.contains('open')
                        ? '✕'
                        : '☰';

            }
        );

    }


    /*
    |--------------------------------------------------------------------------
    | CONTADOR DESCRIÇÃO
    |--------------------------------------------------------------------------
    */

    const description =
        document.getElementById('description');

    const descriptionCount =
        document.getElementById('descriptionCount');


    function updateDescriptionCount() {

        if (!description || !descriptionCount) {
            return;
        }


        descriptionCount.textContent =
            `${description.value.length} / 5000`;

    }


    if (description) {

        description.addEventListener(
            'input',
            updateDescriptionCount
        );

        updateDescriptionCount();

    }

});