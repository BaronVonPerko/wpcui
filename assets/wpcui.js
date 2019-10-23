document.addEventListener("DOMContentLoaded", function () {

    /**
     * Show/Hide the control choices text box for specific control types
     */
    let dropdownControls = document.getElementsByClassName('dropdown_control_type');

    [...dropdownControls].forEach(dropdownControl => {
        dropdownControl.onchange = () => {
            let selectedOption = dropdownControl.options[dropdownControl.selectedIndex];
            let hasOptions = selectedOption.dataset.hasOptions;
            let controlChoices = dropdownControl.parentElement.parentElement.nextSibling;

            if (hasOptions) {
                controlChoices.classList.remove('hidden');
            } else {
                if (!controlChoices.classList.contains('hidden')) {
                    controlChoices.classList.add('hidden');
                }
            }
        };
    });


    /**
     * Collapsible sections
     */
    let sectionTitles = document.getElementsByClassName('wpcui-collapsible-title');

    [...sectionTitles].forEach(title => {
        title.onclick = () => {
            let panel = title.parentElement.parentElement;

            let isCollapsed = panel.getAttribute('data-wpcui-collapsed');

            panel.setAttribute('data-wpcui-collapsed', isCollapsed ? "" : "true");
        };
    });
});