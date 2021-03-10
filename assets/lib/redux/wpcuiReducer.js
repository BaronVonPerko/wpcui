import { createStore } from "redux";
import {
  createSection,
  deleteSection,
  toggleSectionVisibility,
  updateSection,
} from "./sectionActions";
import { createControl } from "./controlActions";

const initialState = {
  db_version: -1,
  panels: [],
  sections: [],
  controls: [],
  selectedSection: null,
  notification: {},
};

export const actions = {
  DATA_FETCH: 0,
  DELETE_SECTION: 1,
  CREATE_SECTION: 2,
  SELECT_SECTION: 3,
  CLOSE_SECTION: 4,
  CREATE_CONTROl: 5,
  UPDATE_SECTION: 6,
  TOGGLE_SECTION_VISIBILITY: 7,
  NOTIFY: 8,
  CLEAR_NOTIFICATION: 9,
};

function wpcuiReducer(state = initialState, action) {
  switch (action.type) {
    case actions.DATA_FETCH:
      return { ...state, ...action.data };

    case actions.DELETE_SECTION:
      return deleteSection(state, action.sectionId);

    case actions.CREATE_SECTION:
      return createSection(state, action.section);

    case actions.SELECT_SECTION:
      return { ...state, selectedSection: action.section };

    case actions.CLOSE_SECTION:
      return { ...state, selectedSection: null };

    case actions.CREATE_CONTROl:
      return createControl(state, action.control);

    case actions.UPDATE_SECTION:
      return updateSection(state, action.oldSectionId, action.updatedSection);

    case actions.TOGGLE_SECTION_VISIBILITY:
      return toggleSectionVisibility(state, action.sectionId);

    case actions.NOTIFY:
      return {
        ...state,
        notification: {
          type: actions.type ?? "success",
          message: actions.message,
        },
      };

    case actions.CLEAR_NOTIFICATION:
      return { ...state, notification: {} };

    default:
      return state;
  }
}

const store = createStore(wpcuiReducer);

export default store;
