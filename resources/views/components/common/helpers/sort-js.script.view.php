<?php declare(strict_types=1); ?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        $('form').submit(function () {
            $('input[type="radio"].defaultSort').prop('disabled', true);
        });

        let sortInputs = $('input[type="radio"][name^="sort["]')

        sortInputs.click(function() {
            let currentInput = $(this);
            let currentInputName = currentInput.attr('name');
            let otherDefaultInputs = $('input[type="radio"][name^="sort["][name!="' + currentInputName + '"][id$="_default"]');
            let otherAscInputs = $('input[type="radio"][name^="sort["][name!="' + currentInputName + '"][id$="_asc"]');
            let otherDescInputs = $('input[type="radio"][name^="sort["][name!="' + currentInputName + '"][id$="_desc"]');
            otherDefaultInputs.prop('checked', true).trigger('change')
            otherAscInputs.prop('checked', false).trigger('change')
            otherDescInputs.prop('checked', false).trigger('change')
            $("#apply_sort_button").trigger('click');
        });

        sortInputs.change(function() {
            let currentInput = $(this);
            let currentInputId = currentInput.attr('id')
            let currentLabel = $(`label[for="${currentInputId}"]`)
            let targetLabel = $("." + currentInputId + "_label")
            if (currentInput.prop('checked')) {
                currentLabel.addClass('d-none');
                targetLabel.removeClass('d-none');
            } else {
                targetLabel.addClass('d-none');
            }
        });
    });
</script>