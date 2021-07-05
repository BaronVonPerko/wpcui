import Button from "../elements/Button";
import FormTextInput from "../elements/FormTextInput";
import FormCancel from "../elements/FormCancel";
import FormCheckbox from "../elements/FormCheckbox";
import WarningBar from "../elements/WarningBar";
import { hideModal } from "../components/Modal";
import React = require("react");
import { connect } from "react-redux";
import { DatabaseObject } from "../models/models";
import { ModalWrapper, ModalContent } from "../styled";
import useSectionForm from "../hooks/useSectionForm";

interface IProps {
  data: DatabaseObject;
}

const SectionForm = (props: IProps) => {
  const {
    sectionId,
    sectionTitle,
    errorTitle,
    errorMessage,
    setError,
    sectionIdChange,
    sectionTitleChange,
    autoGenerateIdChange,
    autoGenerateId,
    save,
  } = useSectionForm(props.data);

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
