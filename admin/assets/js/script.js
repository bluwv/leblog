document.addEventListener('DOMContentLoaded', () => {

    // Toggle button to change the type of password field
    document.querySelectorAll('[data-show-password]').forEach((element) =>{
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


    //
    document.querySelector('[data-action="modal.delete"]').addEventListener('click', (button) => {
        button.preventDefault();
        document.querySelector('dialog').showModal();
    });


     document.querySelector('[data-action="modal.close"]').addEventListener('click', (button) => {
        button.preventDefault();
        document.querySelector('dialog').close();
    });
});
