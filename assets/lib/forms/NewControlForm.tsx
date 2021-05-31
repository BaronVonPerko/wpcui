import { Component } from "react";
import Button from "../elements/Button";
import store, { actions } from "../redux/wpcuiReducer";
import FormTextInput from "../elements/FormTextInput";
import FormCancel from "../elements/FormCancel";
import { controlIdExists, stringToSnakeCase } from "../common";
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

interface IState {
  newControlId: string;
  oldControlId: string; // only used for updates
  newControlLabel: string;
  newDefault: string;
  autoGenerateId: string;
  newControlType: ControlType;
  newChoices: string;
  errorTitle: string;
  errorMessage: string;
}

interface IProps {
  data: DatabaseObject;
  control?: CustomizerControl;
}

class NewControlForm extends Component<IProps, IState> {
  constructor(props) {
    super(props);

    this.state = {
      newControlId: this.props.control ? this.props.control.id : "",
      oldControlId: this.props.control ? this.props.control.id : "",
      newControlLabel: this.props.control ? this.props.control.label : "",
      newDefault: this.props.control ? this.props.control.default : "",
      newControlType: this.props.control ? GetControlTypeById(this.props.control.type).value : ControlType.TEXT,
      autoGenerateId: this.props.control ? (this.props.control.autoGenerateId ? "checked" : "") : "checked",
      newChoices: this.props.control ? this.props.control.choices.join(',') : "",
      errorTitle: "",
      errorMessage: "",
    };

    this.handleControlTitleChange = this.handleControlTitleChange.bind(this);
    this.handleControlIdChange = this.handleControlIdChange.bind(this);
    this.handleAutoGenerateIdChange = this.handleAutoGenerateIdChange.bind(
      this
    );
    this.handleControlDefaultChange = this.handleControlDefaultChange.bind(
      this
    );
    this.createNewControl = this.createNewControl.bind(this);
    this.handleControlTypeChange = this.handleControlTypeChange.bind(this);
    this.handleControlChoicesChange = this.handleControlChoicesChange.bind(
      this
    );
  }

  /**
   * Create a new section with the given id and title.
   */
  createNewControl() {
    if (!this.state.newControlLabel || !this.state.newControlId) {
      this.setState({
        errorTitle: "Missing Required Fields",
        errorMessage: "Controls Title and ID are required.",
      });
      return;
    }

    if (!this.props.control && controlIdExists(this.state.newControlId, this.props.data)) {
      this.setState({
        errorTitle: "Control Id Exists",
        errorMessage: "Control IDs must be unique across all sections.",
      });
      return;
    }

    const newControl: CustomizerControl = {
      id: this.state.newControlId,
      type: this.state.newControlType,
      label: this.state.newControlLabel,
      priority: 99,
      visible: true,
      choices: this.state.newChoices.split(','),
      default: this.state.newDefault,
      autoGenerateId: this.state.autoGenerateId === "checked"
    };

    store.dispatch({
      type: this.props.control ? actions.UPDATE_CONTROL : actions.CREATE_CONTROl,
      control: newControl,
      oldId: this.props.control?.id
    });

    hideModal();
  }

  handleControlTitleChange(event) {
    this.setState({ newControlLabel: event.target.value });

    if (this.state.autoGenerateId) {
      this.setState({ newControlId: stringToSnakeCase(event.target.value) });
    }
  }

  handleControlIdChange(event) {
    this.setState({ newControlId: event.target.value });
  }

  handleAutoGenerateIdChange() {
    if (!this.state.autoGenerateId) {
      this.setState({
        newControlId: stringToSnakeCase(this.state.newControlLabel),
      });
    }

    this.setState({
      autoGenerateId: this.state.autoGenerateId == "checked" ? "" : "checked",
    });
  }

  handleControlDefaultChange(event) {
    this.setState({ newDefault: event.target.value });
  }

  handleControlTypeChange(event) {
    this.setState({ newControlType: event.target.value });
  }

  handleControlChoicesChange(event) {
    this.setState({ newChoices: event.target.value });
  }

  renderChoices() {
    const selectedType = Number.parseInt(this.state.newControlType.toString());
    const hasOptions = ControlTypesWithOptions.includes(selectedType);

    if (!hasOptions) {
      return null;
    }

    return (
      <FormTextInput
        label="Choices"
        inputId="newChoices"
        placeholder="Comma separated list of choices to display"
        onChange={this.handleControlChoicesChange}
        value={this.state.newChoices}
      />
    );
  }

  render() {
    return (
      <ModalWrapper>
        <ModalContent>
          <h3>Create a New Customizer Control</h3>
          <WarningBar
            title={this.state.errorTitle}
            innerText={this.state.errorMessage}
          />
          <table className="form-table">
            <tbody>
              <FormTextInput
                label="Control Title"
                inputId="newControlTitle"
                placeholder="New Control Name"
                onChange={this.handleControlTitleChange}
                value={this.state.newControlLabel}
              />
              <FormCheckbox
                label="Auto-Generate ID"
                checked={!!this.state.autoGenerateId}
                handleChange={this.handleAutoGenerateIdChange}
              />
              <FormTextInput
                label="Control ID"
                inputId="newControlId"
                placeholder="New Control ID"
                onChange={this.handleControlIdChange}
                value={this.state.newControlId}
                disabled={this.state.autoGenerateId != null}
              />
              <FormTextInput
                label="Default Value"
                inputId="newDefault"
                placeholder="Default Value"
                onChange={this.handleControlDefaultChange}
                value={this.state.newDefault}
              />
              <FormSelect
                inputId="newType"
                label="Control Type"
                onChange={this.handleControlTypeChange}
                options={ControlTypeSelectOptions}
                value={this.state.newControlType}
              />
              {this.renderChoices()}
            </tbody>
          </table>
          <Button
            buttonType="primary"
            innerText={this.props.control ? "Update Control" : "Create New Control"}
            click={this.createNewControl}
          />
          <FormCancel handleClick={hideModal} />
        </ModalContent>
      </ModalWrapper>
    );
  }
}

const mapStateToProps = (state) => ({
  data: state,
});
export default connect(mapStateToProps)(NewControlForm);
