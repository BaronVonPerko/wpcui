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
  };
  saveData(createSectionState).then(() => {
    // todo: modal save complete
  });
  return createSectionState;
}
