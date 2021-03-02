import { createStore } from "redux";
import { saveData } from "../services/api";

const initialState = {
  db_version: -1,
  panels: [],
  sections: [],
};

export const actions = {
  DATA_FETCH: 0,
  DELETE_SECTION: 1,
  CREATE_SECTION: 2,
};

function wpcuiReducer(state = initialState, action) {
  switch (action.type) {
    case actions.DATA_FETCH:
      return action.data;

    case actions.DELETE_SECTION:
      const deleteSectionState = {
        ...state,
        sections: state.sections.filter(
          (section) => section.id !== action.sectionId
        ),
      };
      saveData(deleteSectionState).then(() => {
        // todo: modal save complete
      });
      return deleteSectionState;

    case actions.CREATE_SECTION:
      const createSectionState = {
        ...state,
        sections: [...state.sections, action.section],
      };
      saveData(createSectionState).then(() => {
        // todo: modal save complete
      });
      return createSectionState;

    default:
      return state;
  }
}

const store = createStore(wpcuiReducer);

export default store;
