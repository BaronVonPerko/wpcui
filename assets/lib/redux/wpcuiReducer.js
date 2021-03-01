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
      return { sections };
    case actions.CREATE_SECTION:
      state.sections.push(action.section);

      saveData(state).then(() => {
        // todo: modal save complete
      });

      return state;
    default:
      return state;
  }
}

const store = createStore(wpcuiReducer);

// store.subscribe(() => console.log(store.getState()));

export default store;
