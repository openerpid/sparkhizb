$(document).ready(function () {
    bsCustomFileInput.init()

    var btn = document.getElementById('btnResetForm')
    var form = document.querySelector('form')
    btn.addEventListener('click', function() {
        form.reset()
    })
});