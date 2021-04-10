import { saveData } from "../services/api";
import { notify, messages } from "../components/Notification";
import { ApplicationState } from "../models/models";

export function createControl(state, control): ApplicationState {
  let updatedSectionControls = state.selectedSection.controls;
  updatedSectionControls.push(control);

  const selectedSectionIndex = state.sections.findIndex(
    (section) => section.id === state.selectedSection.id
  );
  let newSections = [...state.sections];
  newSections[selectedSectionIndex] = {
    ...newSections[selectedSectionIndex],
    controls: updatedSectionControls,
  };

  const createControlState: ApplicationState = {
    ...state,
    sections: newSections,
  };
  saveData(createControlState).then(() => {
    notify(messages.SAVE_SUCCESS);
  });

  return { ...createControlState, selectedSection: state.selectedSection };
}

export function deleteControl(state, controlId: string): ApplicationState {
  let sections = state.sections;
  sections.forEach((section) => {
    section.controls = section.controls.filter(
      (control) => control.id !== controlId
    );
  });
  const deleteControlState = {
    ...state,
    sections,
  };

  saveData({ ...deleteControlState }).then(() => {
    notify(messages.SAVE_SUCCESS);
  });

  return deleteControlState;
}
