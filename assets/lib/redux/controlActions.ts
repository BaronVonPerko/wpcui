import { saveData } from "../services/api";
import { notify, messages } from "../components/Notification";
import { ApplicationState, Control } from "../models/models";

export function createControl(
  state: ApplicationState,
  control: Control
): ApplicationState {
  // Find the selected section index to add the control to
  const selectedSectionIndex = getSelectedSectionIndex(state);

  // Add new control to the section
  let controls = state.sections[selectedSectionIndex].controls;
  controls.push(control);

  // Grab the sections and update the controls
  let sections = [...state.sections];
  sections[selectedSectionIndex] = {
    ...sections[selectedSectionIndex],
    controls: controls,
  };

  // Update the selected section controls so that the UI is updated
  const selectedSection = { ...sections[selectedSectionIndex] };

  // Create the new State
  const createControlState: ApplicationState = {
    ...state,
    sections,
    selectedSection,
  };

  // Save to the database
  saveData(createControlState).then(() => {
    notify(messages.SAVE_SUCCESS);
  });

  return { ...createControlState };
}

export function deleteControl(
  state: ApplicationState,
  controlId: string
): ApplicationState {
  const selectedSectionIndex = getSelectedSectionIndex(state);

  let sections = state.sections;
  sections.forEach((section) => {
    section.controls = section.controls.filter(
      (control) => control.id !== controlId
    );
  });

  const selectedSection = { ...sections[selectedSectionIndex] };

  const deleteControlState = {
    ...state,
    sections,
    selectedSection,
  };

  saveData({ ...deleteControlState }).then(() => {
    notify(messages.SAVE_SUCCESS);
  });

  return { ...deleteControlState };
}

function getSelectedSectionIndex(state: ApplicationState): number {
  return state.sections.findIndex(
    (section) => section.id === state.selectedSection.id
  );
}
