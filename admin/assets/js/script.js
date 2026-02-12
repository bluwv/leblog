document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-show-password]').forEach(element, () =>{
        element.addEventListener('click', (e) => {
            e.preventDefault();

            const input = e.target.previousElementSibling;

            if (input.type == "password") {
                input.type = "text";
            } else {
                input.type = "password";
            }
        });
    });
});
