function validateForm(form) {
    var login = form.login.value;
    var password = form.password.value;
    var password_confirm = form.password_confirm.value;
    
    if (login.length < 3) {
        alert('Логин должен быть не менее 3 символов');
        return false;
    }
    
    if (password.length < 6) {
        alert('Пароль должен быть не менее 6 символов');
        return false;
    }
    
    if (password !== password_confirm) {
        alert('Пароли не совпадают');
        return false;
    }
    
    return true;
}
