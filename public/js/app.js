document.addEventListener('DOMContentLoaded', function () {

    const menuButton =
        document.getElementById('menuButton');

    const mainNav =
        document.getElementById('mainNav');


    if (menuButton && mainNav) {

        menuButton.addEventListener(
            'click',
            function () {

                mainNav.classList.toggle('mobile-open');

            }
        );

    }

});