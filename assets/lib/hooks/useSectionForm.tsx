import { sectionIdExists, stringToSnakeCase } from "../common";
import { useState } from "react";
import store, { actions } from "../redux/wpcuiReducer";
import { hideModal } from "../components/Modal";
import { DatabaseObject } from "../models/models";

export default function useSectionForm(data: DatabaseObject) {
  const [sectionId, setSectionId] = useState("");
  const [sectionTitle, setSectionTitle] = useState("");
  const [autoGenerateId, setAutoGenerateId] = useState("checked");
  const [errorTitle, setErrorTitle] = useState("");
  const [errorMessage, setErrorMessage] = useState("");

  const sectionTitleChange = (e) => {
    setSectionTitle(e.target.value);

    if (autoGenerateId) {
      setSectionId(stringToSnakeCase(e.target.value));
    }
  };

  const sectionIdChange = (e) => {
    setSectionId(e.target.value);
  };

  const autoGenerateIdChange = () => {
    if (!autoGenerateId) {
      setSectionId(stringToSnakeCase(sectionTitle));
    }

    setAutoGenerateId(autoGenerateId == "checked" ? "" : "checked");
  };

  const setError = (title, message) => {
    setErrorTitle(title);
    setErrorMessage(message);
  };

  const save = () => {
    if (!sectionTitle || !sectionId) {
      setError("Missing Required Fields", "Section Title and ID are required.");
      return;
    }

    if (sectionIdExists(sectionId, data)) {
      setError(
        "Section Id Exists",
        "Section IDs must be unique across all sections."
      );
      return;
    }

    const newSection = {
      id: sectionId,
      title: sectionTitle,
      priority: 99,
      visible: true,
      controls: [],
    };

    store.dispatch({ type: actions.CREATE_SECTION, section: newSection });

    hideModal();
  };

  return {
    sectionTitleChange,
    sectionIdChange,
    autoGenerateIdChange,
    sectionTitle,
    sectionId,
    autoGenerateId,
    errorMessage,
    errorTitle,
    setError,
    save,
  };
}
