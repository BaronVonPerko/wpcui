import { saveData } from "../services/api";
import { messages, notify } from "../components/Notification";
import { ApplicationState } from "../models/models";

export function deleteSection(state, sectionId): ApplicationState {
  const deleteSectionState = {
    ...state,
    sections: state.sections.filter((section) => section.id !== sectionId),
    selectedSection: null,
  };
  saveData({ ...deleteSectionState }).then(() => {
    notify(messages.SAVE_SUCCESS);
  });

  return deleteSectionState;
}

export function createSection(state, section): ApplicationState {
  const createSectionState: ApplicationState = {
    ...state,
    sections: [...state.sections, section],
    selectedSection: section,
  };
  saveData({ ...createSectionState }).then(() => {
    notify(messages.SAVE_SUCCESS);
  });
  return createSectionState;
}

export function updateSection(
  state,
  oldSectionId,
  updatedSection
): ApplicationState {
  let updatedSections = [...state.sections];

  updatedSections.forEach((section, index) => {
    if (section.id === oldSectionId) {
      updatedSections[index] = updatedSection;
    }
  });

  const updateSectionState: ApplicationState = {
    ...state,
    sections: updatedSections,
    selectedSection: null,
  };

  saveData({ ...updateSectionState }).then(() => {
    notify(messages.SAVE_SUCCESS);
  });

  return updateSectionState;
}

export function toggleSectionVisibility(state, sectionId): ApplicationState {
  let section = state.sections.find((section) => section.id === sectionId);

  section.visible = !section.visible;

  return updateSection(state, sectionId, section);
}
