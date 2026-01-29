document.addEventListener('DOMContentLoaded', () => {

    document.querySelectorAll('.nav-link').forEach((link) => {

        link.addEventListener('click', (element) => {
            element.preventDefault();

            document.querySelector('.nav-link.active').classList.remove('active');
            element.currentTarget.classList.add('active');
        });

    });

});
