document.addEventListener('DOMContentLoaded', function () {
    var form = document.querySelector('form');
    form.addEventListener('submit', function (e) {
        var mdp = document.getElementById('mdp').value;
        if (/\s/.test(mdp)) {
            alert('Le mot de passe ne doit pas contenir d\'espaces.');
            e.preventDefault();
        }
    });
});
