function validate() {
    var name = document.form.name;
    var address = document.form.address;
    var email = document.form.email;
    var phone = document.form.phone;
    var status = document.form.status;
    var salary = document.form.salary;


    if (name.value.length <= 0) {
        var user = document.getElementById('err_name').innerHTML = "Please enter your name";
        document.form.name.focus();
        return false;
    }
    if (email.value.length <= 0) {
        var user = document.getElementById('err_email').innerHTML = "Please enter your email";
        document.form.email.focus();
        document.getElementById('err_name').innerHTML = "";
        return false;
    }

    if (phone.value.length <= 0) {
        var user = document.getElementById('err_phone').innerHTML = "Please enter your phone";
        document.form.phone.focus();
        document.getElementById('err_email').innerHTML = "";
        return false;
    }
    if (salary.value.length <= 0) {
        var user = document.getElementById('err_salary').innerHTML = "Please enter your salary";
        document.form.salary.focus();
        document.getElementById('err_phone').innerHTML = "";
        return false;
    }
    if (status.value.length <= 0) {
        var user = document.getElementById('err_status').innerHTML = "Please enter your status";
        document.form.status.focus();
        document.getElementById('err_salary').innerHTML = "";
        return false;
    }

    if (address.value.length <= 0) {
        var user = document.getElementById('err_address').innerHTML = "Please enter your address";
        document.form.address.focus();
        document.getElementById('err_status').innerHTML = "";
        return false;
    }

    return true;
}