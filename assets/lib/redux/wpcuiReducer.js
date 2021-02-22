import { createStore } from "redux";

function wpcuiReducer(state = {}, action) {
  return state;
}

let store = createStore(wpcuiReducer);

store.subscribe(() => console.log(store.getState()));

export default store;
