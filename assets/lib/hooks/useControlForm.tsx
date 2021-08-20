import { controlIdExists, stringToSnakeCase } from "../common";
import { useState } from "react";
import store, { actions } from "../redux/wpcuiReducer";
import { hideModal } from "../components/Modal";
import { Control, ControlType, DatabaseObject } from "../models/models";

export default function useControlForm(data: DatabaseObject, control: Control) {
  const initialControlId = data.settings.controlPrefix
    ? `${data.settings.controlPrefix}_${control?.id || ""}`
    : stringToSnakeCase(control?.id);
  const [controlId, setControlId] = useState(initialControlId || "");
  const [controlLabel, setControlLabel] = useState(control?.label || "");
  const [controlDefault, setControlDefault] = useState(control?.default || "");
  const [controlType, setControlType] = useState(control?.type || ControlType.TEXT);
  const [controlChoices, setControlChoices] = useState(control?.choices || []);
  const [autoGenerateId, setAutoGenerateId] = useState("checked");
  const [errorTitle, setErrorTitle] = useState("");
  const [errorMessage, setErrorMessage] = useState("");
  const oldControlId = control?.id;

  const controlLabelChange = (e) => {
    setControlLabel(e.target.value);

    if (autoGenerateId) {
      const id = data.settings.controlPrefix
        ? `${data.settings.controlPrefix}_${stringToSnakeCase(e.target.value)}`
        : stringToSnakeCase(e.target.value);

      setControlId(id);
    }
  };

  const autoGenerateIdChange = () => {
    if (!autoGenerateId) {
      setControlId(stringToSnakeCase(controlLabel));
    }

    setAutoGenerateId(autoGenerateId == "checked" ? "" : "checked");
  };

  const controlDefaultChange = (e) => {
    setControlDefault(e.target.value);
  };

  const controlIdChange = (e) => {
    const cleanedId = e.target.value.replace(`${data.settings.controlPrefix}_`, "");
    setControlId(data.settings.controlPrefix
      ? `${data.settings.controlPrefix}_${cleanedId}`
      : cleanedId);
  };

  const controlTypeChange = (e) => {
    setControlType(e.target.value);
  };

  const controlChoicesChange = (e) => {
    setControlChoices(e.target.value);
  };

  const setError = (title, message) => {
    setErrorTitle(title);
    setErrorMessage(message);
  };

  const save = () => {
    if (!controlLabel || !controlId) {
      setError("Missing Required Fields", "Control Label and ID are required.");
      return;
    }

    // don't save the prefix
    const cleanedId = controlId.replace(`${data.settings.controlPrefix}_`, "");

    if (oldControlId !== cleanedId && controlIdExists(cleanedId, data)) {
      setError(
        "Control Id Exists",
        "Control IDs must be unique across all controls, regardless of what section they are in."
      );
      return;
    }

    const newControl: Control = {
      id: cleanedId,
      label: controlLabel,
      priority: 99,
      visible: true,
      type: controlType,
      default: controlDefault,
      choices: controlChoices,
      autoGenerateId: autoGenerateId == "checked"
    };
    console.log(newControl);

    if (control) {
      store.dispatch({
        type: actions.UPDATE_CONTROL,
        control: newControl,
        oldId: oldControlId
      });
    } else {
      store.dispatch({ type: actions.CREATE_CONTROl, control: newControl });
    }

    hideModal();
  };

  return {
    controlLabelChange,
    autoGenerateIdChange,
    controlDefault,
    controlDefaultChange,
    controlLabel,
    controlId,
    controlIdChange,
    autoGenerateId,
    controlType,
    controlTypeChange,
    controlChoices,
    controlChoicesChange,
    errorMessage,
    errorTitle,
    save
  };
}
