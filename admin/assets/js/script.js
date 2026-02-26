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
    document.querySelectorAll('[data-action="modal.delete"]').forEach((modal) => {
        modal.addEventListener('click', (button) => {
            button.preventDefault();
            document.querySelector('dialog').showModal();
            document.querySelector('dialog').querySelector('[name="delete"]').value = button.currentTarget.value;
        });
    });


     document.querySelector('[data-action="modal.close"]').addEventListener('click', (button) => {
        button.preventDefault();
        document.querySelector('dialog').close();
    });
});
