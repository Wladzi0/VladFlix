$('#addFormFilm').submit(function (e) {
    e.preventDefault();
    let form = $(this);
    $.ajax({
        type: form.attr('method'),
        url: form.attr('action'),
        data: form.serialize(),
    })
})