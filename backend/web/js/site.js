"use strict";

$(function() {
    $(document).on('click', '#apples-generate', applesGenerate);
    $(document).on('click', '#apple-fall', appleFallToGround);
    $(document).on('click', '#apple-eat', appleEat);
});


async function applesGenerate() {
    await fetch('generate');
    $.pjax.reload({container: '#pjaxAppleIndex'});
}

async function appleFallToGround() {
    const id = $('h1').text();
    await fetch(`fall-to-ground?id=${id}`);
    $.pjax.reload({container: '#pjaxAppleView'});
}

async function appleEat() {
    const id = $('h1').text();
    const $percent = $('#apple-eat-percent');
    const percent = $percent.val();
    $percent.val('');
    await fetch(`eat?id=${id}&percent=${percent}`);
    $.pjax.reload({container: '#pjaxAppleView'});
}
