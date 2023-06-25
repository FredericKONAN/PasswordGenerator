

// document.addEventListener('DOMContentLoaded', function (){

    const form = document.getElementById('js-password-generator-form');

    const lengthSelect = document.getElementById('length');
    const upperCaseLettersCheckbox = document.getElementById('uppercase-letters');
    const digitsCheckbox = document.getElementById('digits');
    const specialCharacterCheckbox = document.getElementById('special-characters');

    passwordPreferences = JSON.parse( localStorage.getItem('password_preferences'))

    if (passwordPreferences){
        lengthSelect.value = passwordPreferences.password_length
        upperCaseLettersCheckbox.checked = passwordPreferences.uppercaseLetters
        digitsCheckbox.checked = passwordPreferences.digits
        specialCharacterCheckbox.checked = passwordPreferences.sepcial_characters

    }

    form.addEventListener('submit', function (e){
        // e.preventDefault();
        localStorage.setItem('password_preferences', JSON.stringify({
            'password_length' : parseInt( lengthSelect.value, 10),
            'uppercaseLetters' : upperCaseLettersCheckbox.checked,
            'digits':digitsCheckbox.checked,
            'sepcial_characters' :specialCharacterCheckbox.checked
        }));

        // form.submit();
        //this.submit

    });
// });