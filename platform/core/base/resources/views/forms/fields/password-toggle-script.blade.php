<style>
    .input-password-toggle {
        position: absolute;
        right: 0;
        top: 0;
        cursor: pointer;
        padding: 10px 15px;
        z-index: 9;
    }

    input[data-bb-password]:valid, input[data-bb-password].is-valid {
        background-image: unset;
    }
</style>

<script>
    document.querySelectorAll('[data-bb-toggle-password]').forEach(button => {
        button.addEventListener('click', () => {
            const passwordField = button.parentElement.querySelector('[data-bb-password]');
            const icon = button.querySelector('svg');

            if (passwordField.getAttribute('type') === 'password') {
                passwordField.setAttribute('type', 'text');
                icon.setAttribute('class', 'icon icon-tabler icon-tabler-eye-off');
                icon.innerHTML = `
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <path d="M3 3l18 18"></path>
                <path d="M10.585 10.585a2 2 0 0 0 2.83 2.83"></path>
                <path d="M9.878 15.121c-2.735 -.948 -4.878 -2.735 -4.878 -3.121c0 -.386 2.143 -2.173 4.878 -3.121m3.5 -.621c1.562 .434 3.006 1.184 4.126 2.106c.956 .797 1.874 1.803 2.496 2.635"></path>
                <path d="M14.121 14.121c-.949 2.735 -2.735 4.878 -3.121 4.878c-.386 0 -2.173 -2.143 -3.121 -4.878m-.621 -3.5c.434 -1.562 1.184 -3.006 2.106 -4.126c.797 -.956 1.803 -1.874 2.635 -2.496"></path>
            `;
            } else {
                passwordField.setAttribute('type', 'password');
                icon.setAttribute('class', 'icon icon-tabler icon-tabler-eye');
                icon.innerHTML = `
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <circle cx="12" cy="12" r="2"></circle>
                <path d="M22 12c0 3.866 -5.373 7 -10 7s-10 -3.134 -10 -7 5.373 -7 10 -7 10 3.134 10 7"></path>
            `;
            }
        });
    });
</script>
