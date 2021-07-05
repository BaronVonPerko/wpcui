import { useState } from "react";
import Button from "../elements/Button";
import store, { actions } from "../redux/wpcuiReducer";
import FormTextInput from "../elements/FormTextInput";
import FormCancel from "../elements/FormCancel";
import { sectionIdExists, stringToSnakeCase } from "../common";
import FormCheckbox from "../elements/FormCheckbox";
import WarningBar from "../elements/WarningBar";
import { hideModal } from "../components/Modal";
import React = require("react");
import { connect } from "react-redux";
import { DatabaseObject } from "../models/models";
import { ModalWrapper, ModalContent } from "../styled";

interface IProps {
  data: DatabaseObject;
}

const SectionForm = (props: IProps) => {
  const [sectionId, setSectionId] = useState("");
  const [sectionTitle, setSectionTitle] = useState("");
  const [autoGenerateId, setAutoGenerateId] = useState("checked");
  const [errorTitle, setErrorTitle] = useState("");
  const [errorMessage, setErrorMessage] = useState("");

  const save = () => {
    if (!sectionTitle || !sectionId) {
      setErrorTitle("Missing Required Fields");
      setErrorMessage("Section Title and ID are required.");
      return;
    }

    if (sectionIdExists(sectionId, props.data)) {
      setErrorTitle("Section Id Exists");
      setErrorMessage("Section IDs must be unique across all sections.");
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

  return (
    <ModalWrapper>
      <ModalContent>
        <h3>Create a New Customizer Section</h3>
        <WarningBar title={errorTitle} innerText={errorMessage} />
        <table className="form-table">
          <tbody>
            <FormTextInput
              label="Section Title"
              inputId="newSectionTitle"
              placeholder="New Section Name"
              onChange={sectionTitleChange}
              value={sectionTitle}
            />
            <FormCheckbox
              label="Auto-Generate ID"
              checked={autoGenerateId == "checked"}
              handleChange={autoGenerateIdChange}
            />
            <FormTextInput
              label="Section ID"
              inputId="newSectionId"
              placeholder="New Section ID"
              onChange={sectionIdChange}
              value={sectionId}
              disabled={autoGenerateId == "checked"}
            />
          </tbody>
        </table>
        <Button
          buttonType="primary"
          innerText="Create New Section"
          click={save}
        />
        <FormCancel handleClick={hideModal} />
      </ModalContent>
    </ModalWrapper>
  );
};

const mapStateToProps = (state) => ({
  data: state,
});
export default connect(mapStateToProps)(SectionForm);
