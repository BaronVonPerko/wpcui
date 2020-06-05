document.addEventListener("DOMContentLoaded", function () {

    /**
     * Show/Hide the control choices text box for specific control types
     */
    let dropdownControls = document.getElementsByClassName('dropdown_control_type');

    [...dropdownControls].forEach(dropdownControl => {
        dropdownUpdated(dropdownControl); // check if dropdown is already in a state that has options
        dropdownControl.onchange = () => dropdownUpdated(dropdownControl);
    });

    function dropdownUpdated(dropdownControl) {
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
    }


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


    /**
     * Click copy on example control code
     */
    let copyIcons = document.getElementsByClassName('wpcui-copy-icon');

    [...copyIcons].forEach(copyIcon => {
        copyIcon.onclick = () => {
            copyIcon.previousElementSibling.select();
            document.execCommand('copy');
            alert('Code copied to your clipboard!');
        };
    });


    /**
     * Update the hidden form field any time a priority input is changed on the Section Manager page
     */
    window.updatePriorityForm = function (section, element) {
        console.log(section);
        console.log(element.value);

        let hiddenPriorities = document.getElementById('hidden_priorities');
        hiddenPriorities.value = {section, priority: element.value};
    }

});
