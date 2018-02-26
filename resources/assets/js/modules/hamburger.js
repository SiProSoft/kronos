
$('.navigation--collapse-toggle').on('click', function() {
    toggleNavigation();
});

$('.navigation--darkened-layer').on('click', function() {
    closeNavigation();
});



function toggleNavigation() {
    $('.navigation--collapse-toggle').toggleClass('is-active');
    $('body').toggleClass('navigation-open');
}

function openNavigation() {
    $('.navigation--collapse-toggle').addClass('is-active');
    $('body').addClass('navigation-open');
}

function closeNavigation() {
    $('.navigation--collapse-toggle').removeClass('is-active');
    $('body').removeClass('navigation-open');
}