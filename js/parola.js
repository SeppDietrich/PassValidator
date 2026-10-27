// Verificare în browser a parolei (aceleași reguli ca în includes/parola.php).
document.addEventListener('DOMContentLoaded', function () {
    var camp = document.getElementById('parola');
    var info = document.getElementById('parola-info');
    if (!camp || !info) return;

    camp.addEventListener('input', function () {
        var v = camp.value;
        var lipsa = [];
        if (v.length < 8) lipsa.push('minim 8 caractere');
        if (!/\p{Lu}/u.test(v)) lipsa.push('o literă mare');
        if (!/\p{Ll}/u.test(v)) lipsa.push('o literă mică');
        if (!/\d/.test(v)) lipsa.push('o cifră');

        if (v === '') {
            info.textContent = '';
        } else if (lipsa.length) {
            info.textContent = 'Mai trebuie: ' + lipsa.join(', ') + '.';
        } else {
            info.textContent = 'Parola respectă regulile.';
        }
    });
});
