$(document).ready(function () {
    document.getElementById('profile_profilePin').disabled = true;

$("#profile_age").on('change', function () {

    if ($(this).val() === '1' || $(this).val() === '2') {
     document.getElementById('profile_profilePin').required = true;
        document.getElementById('profile_profilePin').disabled = false;
    }
    else{
        document.getElementById('profile_profilePin').disabled = true;
        document.getElementById('profile_profilePin').required = false;
    }
});
});
