document.addEventListener("DOMContentLoaded", function () {
    let dropdownControl = document.getElementById('dropdown_control_type');
    let controlOptions = document.getElementsByClassName('control-options')[0];

    dropdownControl.onchange = (e) => {
        let selectedOption = dropdownControl.options[dropdownControl.selectedIndex];

        let hasOptions = selectedOption.dataset.hasOptions;

        if(hasOptions) {
            controlOptions.classList.remove('hidden');
        } else {
            if(!controlOptions.classList.contains('hidden')) {
                controlOptions.classList.add('hidden');
            }
        }
    };
});