import { DatabaseObject } from "../models/models";
import { useState } from "react";
import store, { actions } from "../redux/wpcuiReducer";

export default function useControlPrefixForm(data: DatabaseObject) {
  const [controlPrefix, setControlPefix] = useState(data.settings.controlPrefix);

  const controlPrefixChange = (e) => {
    setControlPefix(e.target.value);
  }

  const save = () => {
    store.dispatch({
      type: actions.SAVE_CONTROL_PREFIX,
      controlPrefix
    });
  }

  return {
    controlPrefix,
    controlPrefixChange,
    save,
  }
}