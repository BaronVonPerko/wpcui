import { createStore } from "redux";
import { createSection, deleteSection } from "./sectionActions";

const initialState = {
  db_version: -1,
  panels: [],
  sections: [],
  selectedSection: null,
};

export const actions = {
  DATA_FETCH: 0,
  DELETE_SECTION: 1,
  CREATE_SECTION: 2,
  SELECT_SECTION: 3,
  CLOSE_SECTION: 4,
};

function wpcuiReducer(state = initialState, action) {
  switch (action.type) {
    case actions.DATA_FETCH:
      return action.data;

    case actions.DELETE_SECTION:
      return deleteSection(state, action.sectionId);

    case actions.CREATE_SECTION:
      return createSection(state, action.section);

    case actions.SELECT_SECTION:
      return { ...state, selectedSection: action.section };

    case actions.CLOSE_SECTION:
      return { ...state, selectedSection: null };

    default:
      return state;
  }
}

const store = createStore(wpcuiReducer);

export default store;
