import { saveData } from "../services/api";

export function createControl(state, control) {
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

  const createControlState = {
    ...state,
    sections: newSections,
  };
  saveData(createControlState).then(() => {
    // todo: modal save complete
  });
  return createControlState;
}
