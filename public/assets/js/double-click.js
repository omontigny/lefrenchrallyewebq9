$(function() {

    $(".button-prevent-multiple-clicks").on("click", function() {
        var $this = $(this);
        console.log('click');

        $this.attr('disabled', true);
    });

    $(".href-prevent-multiple-clicks").on("click", function() {
        var $this = $(this);
        console.log('click2');

        $this.preventDefault();
    });

});