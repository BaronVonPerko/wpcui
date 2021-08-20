import { DatabaseObject } from "../models/models";
import { useState } from "react";

export default function useControlPrefixForm(data: DatabaseObject) {
  const [controlPrefix, setControlPefix] = useState(data.settings.controlPrefix);

  const controlPrefixChange = (e) => {
    setControlPefix(e.target.value);
  }

  const save = () => {
    //
  }

  return {
    controlPrefix,
    controlPrefixChange,
    save,
  }
}