import Button from "../elements/Button";
import FormTextInput from "../elements/FormTextInput";
import FormCancel from "../elements/FormCancel";
import FormCheckbox from "../elements/FormCheckbox";
import WarningBar from "../elements/WarningBar";
import { hideModal } from "../components/Modal";
import { Control as CustomizerControl, ControlType, DatabaseObject } from "../models/models";
import { connect } from "react-redux";
import React = require("react");
import FormSelect from "../elements/FormSelect";
import {
  ControlTypeSelectOptions,
  ControlTypesWithOptions, GetControlTypeById
} from "../models/selectOptions";
import { ModalWrapper, ModalContent } from "../styled";
import useControlForm from "../hooks/useControlForm";



interface IProps {
  data: DatabaseObject;
  control?: CustomizerControl;
}

const ControlForm = (props: IProps) => {
  const {
    errorTitle,
    errorMessage,
    autoGenerateIdChange,
    autoGenerateId,
    controlDefault,
    controlDefaultChange,
    controlId,
    controlIdChange,
    controlType,
    controlTypeChange,
    controlLabel,
    controlLabelChange,
    controlChoices,
    controlChoicesChange,
    save,
  } = useControlForm(props.data, props.control);

  const renderChoices = () => {
    const selectedType = Number.parseInt(controlType.toString());
    const hasOptions = ControlTypesWithOptions.includes(selectedType);

    if (!hasOptions) {
      return null;
    }

    return (
      <FormTextInput
        label="Choices"
        inputId="newChoices"
        placeholder="Comma separated list of choices to display"
        onChange={controlChoicesChange}
        value={controlChoices.join(',')}
      />
    );
  }

  return (
    <ModalWrapper>
      <ModalContent>
        <h3>Create a New Customizer Control</h3>
        <WarningBar
          title={errorTitle}
          innerText={errorMessage}
        />
        <table className="form-table">
          <tbody>
          <FormTextInput
            label="Control Title"
            inputId="newControlTitle"
            placeholder="New Control Name"
            onChange={controlLabelChange}
            value={controlLabel}
          />
          <FormCheckbox
            label="Auto-Generate ID"
            checked={!!autoGenerateId}
            handleChange={autoGenerateIdChange}
          />
          <FormTextInput
            label="Control ID"
            inputId="newControlId"
            placeholder="New Control ID"
            onChange={controlIdChange}
            value={controlId}
            disabled={autoGenerateId != null}
          />
          <FormTextInput
            label="Default Value"
            inputId="newDefault"
            placeholder="Default Value"
            onChange={controlDefaultChange}
            value={controlDefault}
          />
          <FormSelect
            inputId="newType"
            label="Control Type"
            onChange={controlTypeChange}
            options={ControlTypeSelectOptions}
            value={controlType}
          />
          {renderChoices()}
          </tbody>
        </table>
        <Button
          buttonType="primary"
          innerText={props.control ? "Update Control" : "Create New Control"}
          click={save}
        />
        <FormCancel handleClick={hideModal} />
      </ModalContent>
    </ModalWrapper>
  );
}



const mapStateToProps = (state) => ({
  data: state,
});
export default connect(mapStateToProps)(ControlForm);
