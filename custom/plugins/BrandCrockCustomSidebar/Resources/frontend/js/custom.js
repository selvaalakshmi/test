$(function () {
    $('.sidebar--categories-navigation input[type="checkbox"]').on('click', function () {
        window.location = $(this).closest('span').next('label').find('a').attr('href');
    });
});
