/* 
 * Twitter Bootstrap sample code
 */

// fix sub nav on scroll
var $win = $(window)
    , $nav = $('.sidebar-nav')
    , navTop = $('.sidebar-nav').length && $('.sidebar-nav').offset().top - 40
    , isFixed = 0

processScroll()

$win.on('scroll', processScroll)

function processScroll() {
    var i, scrollTop = $win.scrollTop()
    if (scrollTop >= navTop && !isFixed) {
    isFixed = 1
    $nav.addClass('sidebar-nav-fixed')
    $nav.addClass('span2')
    } else if (scrollTop <= navTop && isFixed) {
    isFixed = 0
    $nav.removeClass('sidebar-nav-fixed')
    $nav.removeClass('span2')
    }
}

/*
 * GreenFrogTodoBundle jQuery tools
 */

$(document).ready(function() {
//    $('.editable').editable(Routing.generate('task_edit'), {
//        indicator : 'Saving...',
//        tooltip   : 'Click to edit...',
//        cssclass  : 'form-inline',
//        style  : 'width: 60%',
//        width     : 180
//    });
    $('.editable').editable({
        onSubmit:ajaxEdit
    });
    $('.editable').hover(function() {
        $(this).parent().find('i').toggleClass('icon-pencil');
    });
});

function ajaxEdit(content) {
//    console.log(content);
    var id = this.attr('id').split('-');
    var task = id[1];
    if(content.current != content.previous) {
        $.ajax({
            type: 'GET',
            url: Routing.generate('task_edit'),
            data: {id : task, value : content.current }
        });
    }
}

//$('.well').bind('hover', function() {
//    $(this).find('.progress-striped').toggleClass('active');
//});

$('.taskcb').bind('click', function() {
    var div = $(this).parent().parent();

    var id = $(this).attr('id').split('-');
    var task = id[1];
    //- Send AJAX
    $.post(Routing.generate('task_end', { id: task }), {
        methode: 'POST',
        success: function(){
            //- TODO: Need to show something
//            div.toggle();
        }
    })
});
$('.taskdel').bind('click', function() {
    var div = $(this).parent().parent();

    var id = $(this).attr('id').split('-');
    var task = id[1];
    if(confirm('Are you sure to delete this entry ?')) {
        //- Send AJAX
        $.post(Routing.generate('task_del', { id: task }), {
            methode: 'POST',
            success: function(){
                //- TODO: Need to show something
                div.toggle();
            }
        })        
    } else {
        return false;
    }

});