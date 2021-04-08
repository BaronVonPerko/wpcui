import { Component } from "react";
import Button from "../elements/Button";
import store, { actions } from "../redux/wpcuiReducer";
import FormTextInput from "../elements/FormTextInput";
import FormCancel from "../elements/FormCancel";
import { stringToSnakeCase } from "../common";
import FormCheckbox from "../elements/FormCheckbox";
import WarningBar from "../elements/WarningBar";
import { hideModal } from "../components/Modal";
import { Control } from "../models/models";
import React = require("react");

interface IProps {}
interface IState {
  newControlId: string;
  newControlTitle: string;
  autoGenerateId: string;
  errorTitle: string;
  errorMessage: string;
}

export default class NewControlForm extends Component<IProps, IState> {
  constructor(props) {
    super(props);

    this.state = {
      newControlId: "",
      newControlTitle: "",
      autoGenerateId: "checked",
      errorTitle: "",
      errorMessage: "",
    };

    this.handleControlTitleChange = this.handleControlTitleChange.bind(this);
    this.handleControlIdChange = this.handleControlIdChange.bind(this);
    this.createNewControl = this.createNewControl.bind(this);
    this.handleAutoGenerateIdChange = this.handleAutoGenerateIdChange.bind(
      this
    );
  }

  /**
   * Create a new section with the given id and title.
   */
  createNewControl() {
    if (!this.state.newControlTitle || !this.state.newControlId) {
      this.setState({
        errorTitle: "Missing Required Fields",
        errorMessage: "Controls Title and ID are required.",
      });
      return;
    }

    const newControl: Control = {
      id: this.state.newControlId,
      title: this.state.newControlTitle,
      priority: 99,
      visible: true,
    };

    store.dispatch({
      type: actions.CREATE_CONTROl,
      control: newControl,
    });

    hideModal();
  }

  handleControlTitleChange(event) {
    this.setState({ newControlTitle: event.target.value });

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
        newControlId: stringToSnakeCase(this.state.newControlTitle),
      });
    }

    this.setState({
      autoGenerateId: this.state.autoGenerateId == "checked" ? "" : "checked",
    });
  }

  render() {
    return (
      <div className="wpcui-modal-wrapper">
        <div className="wpcui-modal">
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
                value={this.state.newControlTitle}
              />
              <FormCheckbox
                label="Auto-Generate ID"
                checked={this.state.autoGenerateId ? true : false}
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
            </tbody>
          </table>
          <Button
            buttonType="primary"
            innerText="Create New Control"
            click={this.createNewControl}
          />
          <FormCancel handleClick={hideModal} />
        </div>
      </div>
    );
  }
}
