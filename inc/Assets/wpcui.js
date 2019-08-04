document.addEventListener("DOMContentLoaded", function () {
    let dropdownControl = document.getElementById('dropdown_control_type');
    let controlChoices = document.getElementsByClassName('control-choices')[0];

    dropdownControl.onchange = (e) => {
        let selectedOption = dropdownControl.options[dropdownControl.selectedIndex];

        let hasOptions = selectedOption.dataset.hasOptions;

        if (hasOptions) {
            controlChoices.classList.remove('hidden');
        } else {
            if (!controlChoices.classList.contains('hidden')) {
                controlChoices.classList.add('hidden');
            }
        }
    };


    let sectionTitles = document.getElementsByClassName('wpcui-collapsible-title');

    [...sectionTitles].forEach(title => {
        title.onclick = () => {
            let panel = title.parentElement.parentElement;

            let isCollapsed = panel.getAttribute('data-wpcui-collapsed');

            panel.setAttribute('data-wpcui-collapsed', isCollapsed ? "" : "true");
        };
    });
});