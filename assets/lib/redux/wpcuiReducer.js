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
      const sections = state.sections.filter(
        (section) => section.id !== action.sectionId
      );
      state.sections = sections;
      saveData(state).then(() => {
        // todo: modal save complete
      });
      return { ...state, sections };

    case actions.CREATE_SECTION:
      const newState = {
        ...state,
        sections: [...state.sections, action.section],
      };
      saveData(newState).then(() => {
        // todo: modal save complete
      });
      return newState;

    default:
      return state;
  }
}

const store = createStore(wpcuiReducer);

export default store;
