document.addEventListener('DOMContentLoaded', () => {

    if (document.body.dataset.page == "login") {
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
    }

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

    if (document.body.dataset.page == "edit") {
        (() => {
            'use strict'

            const forms = document.querySelectorAll('form')

            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }

                form.classList.add('was-validated')
                }, false)
            })
        })()

        tinymce.init({
            selector: 'textarea',
            plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
        });
    }
});
