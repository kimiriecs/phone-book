<?php declare(strict_types=1); ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
    $('#create_contact_form').submit(function(e) {
        e.preventDefault();

        let formData = new FormData(this);
        axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
        axios.defaults.headers.common['Accept'] = 'application/json';
        axios.defaults.headers.common['X-CSRF-TOKEN'] = $('#csrf_token').val();

        axios.post($(this).attr('action'), formData)
            .then(response => {
                // Redirect
                if (response.data.redirect_url) {
                    // window.location.href = response.data.redirect_url;
                }
            })
            .catch(error => {
                console.error(error);
            });
    });
</script>