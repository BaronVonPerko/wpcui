import { saveData } from "../services/api";
import store, { actions } from "./wpcuiReducer";
import { messages } from "./../components/Notification";

export function deleteSection(state, sectionId) {
  const deleteSectionState = {
    ...state,
    sections: state.sections.filter((section) => section.id !== sectionId),
    selectedSection: null,
  };
  saveData({ ...deleteSectionState }).then(() => {
    showSuccessMessage();
  });

  return deleteSectionState;
}

export function createSection(state, section) {
  const createSectionState = {
    ...state,
    sections: [...state.sections, section],
    selectedSection: section,
  };
  saveData({ ...createSectionState }).then(() => {
    showSuccessMessage();
  });
  return createSectionState;
}

export function updateSection(state, oldSectionId, updatedSection) {
  let updatedSections = [...state.sections];

  updatedSections.forEach((section, index) => {
    if (section.id === oldSectionId) {
      updatedSections[index] = updatedSection;
    }
  });

  const updateSectionState = {
    ...state,
    sections: updatedSections,
    selectedSection: null,
  };

  saveData({ ...updateSectionState }).then(() => {
    showSuccessMessage();
  });

  return updateSectionState;
}

export function toggleSectionVisibility(state, sectionId) {
  let section = state.sections.find((section) => section.id === sectionId);

  section.visible = !section.visible;

  return updateSection(state, sectionId, section);
}

function showSuccessMessage() {
  store.dispatch({
    type: actions.NOTIFY,
    message: messages.SAVE_SUCCESS,
  });
}
