import { createStore } from "redux";
import { saveData } from "../services/api";

const initialState = {
  db_version: -1,
  panels: [],
  sections: [],
  modalOpen: false,
};

export const actions = {
  DATA_FETCH: 0,
  DELETE_SECTION: 1,
  CREATE_SECTION: 2,
  CLOSE_MODAL: 3,
  OPEN_MODAL: 4,
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
      state.sections.push(action.section);
      saveData(state).then(() => {
        // todo: modal save complete
      });
      state.modalOpen = false;
      return state;

    case actions.CLOSE_MODAL:
      return { ...state, modalOpen: false };

    case actions.OPEN_MODAL:
      return { ...state, modalOpen: true };

    default:
      return state;
  }
}

const store = createStore(wpcuiReducer);

// store.subscribe(() => console.log(store.getState()));

export default store;
