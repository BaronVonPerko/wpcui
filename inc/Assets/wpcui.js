document.addEventListener("DOMContentLoaded", function () {

    /**
     * Show/Hide the control choices text box for specific control types
     */
    let dropdownControls = document.getElementsByClassName('dropdown_control_type');

    [...dropdownControls].forEach(dropdownControl => {
        dropdownControl.onchange = () => {
            let selectedOption = dropdownControl.options[dropdownControl.selectedIndex];
            let hasOptions = selectedOption.dataset.hasOptions;
            let controlChoices = document.getElementsByClassName('control-choices');

            if (hasOptions) {
                [...controlChoices].forEach(controlChoice => controlChoice.classList.remove('hidden'));
            } else {
                [...controlChoices].forEach(controlChoice => {
                    if (!controlChoice.classList.contains('hidden')) {
                        controlChoice.classList.add('hidden');
                    }
                });
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

            if(isCollapsed) {
                // set all panels to be collapsed
                [...document.getElementsByClassName('wpcui-panel')]
                    .forEach(panel => panel.setAttribute('data-wpcui-collapsed', true));

                // open this specific panel
                panel.setAttribute('data-wpcui-collapsed', "");
            }
        };
    });
});