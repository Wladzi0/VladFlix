$("#profile_age").on('change', function () {

    if ($(this).val() === '1' || $(this).val() === '2') {
     document.getElementById('profile_profilePin').required = true;

    }
    else{
        document.getElementById('profile_profilePin').required = false;
    }
});
