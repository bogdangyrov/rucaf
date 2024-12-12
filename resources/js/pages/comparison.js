document.addEventListener("DOMContentLoaded", function () {
    Livewire.hook('commit', ({
        component,
        commit,
        respond,
        succeed,
        fail
    }) => {
        succeed(({
            snapshot,
            effect
        }) => {
            console.log('commit.succeed');
            $('.tabs__content').hide();
            $('.tabs__content:first').show();
            $('.tabs-menu__item:first').addClass('active');

            $('.tabs-menu__link').click(function (e) {
                e.preventDefault();

                $('.tabs-menu__item').removeClass('active');
                $(this).parent().addClass('active');

                $('.tabs__content').hide();
                var activeTab = $(this).attr('href');
                $(activeTab).show();
            });
        })
    })
});
