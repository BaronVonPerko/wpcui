import { saveData } from "../services/api";

export function deleteSection(state, sectionId) {
  const deleteSectionState = {
    ...state,
    sections: state.sections.filter((section) => section.id !== sectionId),
  };
  saveData(deleteSectionState).then(() => {
    // todo: modal save complete
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
    // todo: modal save complete
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
    // todo: modal save complete
  });

  return updateSectionState;
}

export function toggleSectionVisibility(state, sectionId) {
  let section = state.sections.find((section) => section.id === sectionId);

  section.visible = !section.visible;

  return updateSection(state, sectionId, section);
}
