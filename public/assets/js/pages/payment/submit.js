(function() {
    $('.form-prevent-multiple-submits').on('submit',
        function() {
            console.log('submit');
            $('.button-prevent-multiple-submits').attr('disabled', 'true');
        })
})();