import { saveData } from "../services/api";
import store, { actions } from "./wpcuiReducer";
import { messages } from "./../components/Notification";

export function deleteSection(state, sectionId) {
  const deleteSectionState = {
    ...state,
    sections: state.sections.filter((section) => section.id !== sectionId),
  };
  saveData(deleteSectionState).then(() => {
    store.dispatch({
      type: actions.NOTIFY,
      notification: { message: messages.SAVE_SUCCESS },
    });
  });
  return deleteSectionState;
}

export function createSection(state, section) {
  const createSectionState = {
    ...state,
    sections: [...state.sections, section],
    selectedSection: section,
  };
  saveData(createSectionState).then(() => {
    store.dispatch({
      type: actions.NOTIFY,
      notification: { message: messages.SAVE_SUCCESS },
    });
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
  };

  saveData(updateSectionState).then(() => {
    store.dispatch({
      type: actions.NOTIFY,
      notification: { message: messages.SAVE_SUCCESS },
    });
  });

  return updateSectionState;
}

export function toggleSectionVisibility(state, sectionId) {
  let section = state.sections.find((section) => section.id === sectionId);

  section.visible = !section.visible;

  return updateSection(state, sectionId, section);
}
