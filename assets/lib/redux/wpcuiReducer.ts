import { createStore } from "redux";
import {
  createSection,
  deleteSection,
  toggleSectionVisibility,
  updateSection,
} from "./sectionActions";
import { createControl, deleteControl } from "./controlActions";
import { ApplicationState } from "../models/models";

const initialState: ApplicationState = {
  db_version: -1,
  panels: [],
  sections: [],
  selectedSection: null,
  notification: null,
  modalContent: null,
};

export enum actions {
  DATA_FETCH = 0,
  DELETE_SECTION,
  CREATE_SECTION,
  SELECT_SECTION,
  CLOSE_SECTION,
  CREATE_CONTROl,
  UPDATE_SECTION,
  TOGGLE_SECTION_VISIBILITY,
  NOTIFY,
  CLEAR_NOTIFICATION,
  SHOW_MODAL,
  HIDE_MODAL,
  DELETE_CONTROL,
}

function wpcuiReducer(state = initialState, action): ApplicationState {
  switch (action.type) {
    case actions.DATA_FETCH:
      return { ...state, ...action.data };

    /**
     * SECTION ACTIONS
     * */

    case actions.DELETE_SECTION:
      return deleteSection(state, action.sectionId);

    case actions.CREATE_SECTION:
      return createSection(state, action.section);

    case actions.SELECT_SECTION:
      return {
        ...state,
        selectedSection: action.section,
      };

    case actions.CLOSE_SECTION:
      return { ...state, selectedSection: null };

    case actions.UPDATE_SECTION:
      return updateSection(state, action.oldSectionId, action.updatedSection);

    case actions.TOGGLE_SECTION_VISIBILITY:
      return toggleSectionVisibility(state, action.sectionId);

    /**
     * CONTROL ACTIONS
     * */

    case actions.CREATE_CONTROl:
      return createControl(state, action.control);

    case actions.DELETE_CONTROL:
      return deleteControl(state, action.controlId);

    /**
     * NOTIFICATION AND MODAL ACTIONS
     * */

    case actions.NOTIFY:
      return {
        ...state,
        notification: {
          type: action.type ?? "success",
          message: action.message,
        },
      };

    case actions.CLEAR_NOTIFICATION:
      return { ...state, notification: null };

    case actions.SHOW_MODAL:
      return { ...state, modalContent: action.content };

    case actions.HIDE_MODAL:
      return { ...state, modalContent: null };

    default:
      return state;
  }
}

const store = createStore(wpcuiReducer);

export default store;
