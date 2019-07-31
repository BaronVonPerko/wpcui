document.addEventListener("DOMContentLoaded", function () {
    let dropdownControl = document.getElementById('dropdown_control_type');
    let controlChoices = document.getElementsByClassName('control-choices')[0];

    dropdownControl.onchange = (e) => {
        let selectedOption = dropdownControl.options[dropdownControl.selectedIndex];

        let hasOptions = selectedOption.dataset.hasOptions;

        if(hasOptions) {
            controlChoices.classList.remove('hidden');
        } else {
            if(!controlChoices.classList.contains('hidden')) {
                controlChoices.classList.add('hidden');
            }
        }
    };
});